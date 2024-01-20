<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\Product;
use App\Validators\ProductValidator;

class ProductController extends AControllerBase
{
    public function authorize($action): bool
    {
        $user = $this->app->getAuth()->getLoggedUserContext();
        switch ($action) {
            case 'index' :
            case 'filtered':
                return true;

            case 'all' :
            case 'edit':
            case 'add':
            case 'delete' :
            case 'save' :
                return $user->getRole() == 'admin' or $user->getRole() == 'employee';

            default:
                return false;
        }
    }
    public function index(): Response
    {
        if ($this->authorize('index')) {
            $id = (int)$this->request()->getValue('id');
            $product = Product::getOne($id);

            if (is_null($product)) {
                throw new HTTPException(404);
            }

            return $this->html(
                [
                    'product' => $product
                ]
            );
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function all(): JsonResponse
    {
        if ($this->authorize('all')) {
            $products = \App\Models\Product::getAll();
            return new JsonResponse($products);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function filtered(): JsonResponse
    {
        if ($this->authorize('filtered')) {
            $filterValue = $this->request()->getValue('filter');
            $filterColumn = $this->request()->getValue('column');


            $allowedColumns = ['name', 'price']; // stlpce podla ktorých mozme filtrovat
            if (!in_array($filterColumn, $allowedColumns)) {
                // Neplatný stĺpec
                return new JsonResponse(['error' => 'Neplatný stĺpec pre filtrovanie']);
            }
            $filteredProducts = \App\Models\Product::getFiltered([$filterColumn => $filterValue]);
            return new JsonResponse($filteredProducts);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function add(): Response
    {
        if ($this->authorize('add')) {
            return $this->html();
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function edit(): Response
    {
        if ($this->authorize('edit')) {
            $id = (int)$this->request()->getValue('id');
            $product = Product::getOne($id);

            if (is_null($product)) {
                throw new HTTPException(404);
            }

            return $this->html(
                [
                    'product' => $product
                ]
            );
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function save(): JsonResponse
    {
        if ($this->authorize('save')) {
            $dt = new \DateTime();
            $dt->setTimezone(new \DateTimeZone('Europe/Bratislava'));
            $id = (int) $this->request()->getValue('id');
            $oldFileName = "";

            $validator = new ProductValidator();
            if ($id > 0) {
                $product = Product::getOne($id);
                $oldFileName = $product->getImage();
            } else {
                $product = new Product();
            }

            // Validácia názvu
            $name = $this->request()->getValue('name');
            $nameError = $validator->validateName($name);

            // Validácia obrázka
            $file = $this->request()->getFiles()['picture'];
            $pictureError = $validator->validatePicture($file);

            // Validácia ceny
            $price = $this->request()->getValue('price');
            $priceError = $validator->validatePrice($price);

            // Validácia starostlivosti
            $care = $this->request()->getValue('care');
            $careError = $validator->validateCare($care);

            // Validácia popisu
            $description = $this->request()->getValue('description');
            $descriptionError = $validator->validateCare($description);


            // Zoznam chýb validácie
            $formErrors = compact('nameError', 'pictureError', 'priceError', 'careError', 'descriptionError');

            $response = ['success' => false, 'errors' => $formErrors];

            if (empty(array_filter($formErrors))) {
                // Validácia prešla

                if ($oldFileName !== "") {
                    // Ak je starý súbor, zistime či máme nový
                    if ($file['name'] == "") {
                        // Žiadny nový súbor, ostáva starý
                        $newFileName = $oldFileName;
                    } else {
                        // Nový súbor, zmazať starý a uložiť nový
                        FileStorage::deleteFile($oldFileName);
                        $newFileName = FileStorage::saveFile($file);
                    }
                } else {
                    // Bez starého súboru, uložiť nový
                    $newFileName = FileStorage::saveFile($file);
                }

                // Nastavenie hodnôt produktu
                $product->setName($name);
                $product->setCare($care);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setAddedAt($dt->format('Y-m-d H:i:s'));
                $product->setImage($newFileName);
                $product->save();

                // Úspešné uloženie
                $response['success'] = true;
                $response['redirect'] = $this->url("product.index", ['id' => $product->getId()]);
            }

            return new JsonResponse($response);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function delete()
    {
        if ($this->authorize('delete')) {
            $id = (int)$this->request()->getValue('id');
            $product = Product::getOne($id);

            if (is_null($product)) {
                throw new HTTPException(404);
            } else {
                FileStorage::deleteFile($product->getImage());
                $product->delete();
                return new RedirectResponse($this->url("home.index"));
            }
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

}
