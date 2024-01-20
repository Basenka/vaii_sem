<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Models\ShoppingCart;
use App\Models\Product;

class ShoppingCartController extends AControllerBase
{

    public function index(): Response
    {
        $cartItems = ShoppingCart::getAll();
        return $this->html(
            [
                'cartItems' => $cartItems,
            ]
        );
    }


    public function save(): Response
    {
        $productId = (int)$this->request()->getValue('product_id');
        $quantity = (int)$this->request()->getValue('quantity');

        $dt = new \DateTime();
        $dt->setTimezone(new \DateTimeZone('Europe/Bratislava'));

        $auth = $this->app->getAuth();

        $product = Product::getOne($productId);
        if ($product) {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->setProductId($productId);
            $shoppingCart->setQuantity($quantity);
            $shoppingCart->setPrice($product->getPrice());
            $shoppingCart->setCreatedAt($dt->format('Y-m-d H:i:s'));
            if($auth->isLogged()) {
                $user = $auth->getLoggedUserContext();
                $shoppingCart->setUserId($user->getId());
            } else {
                $shoppingCart->setSessionId(session_id());
            }

            $shoppingCart->save();
        } else {
            // Produkt neexistuje
            throw new HTTPException(404);
        }

        // Po pridaní presmeruje na zobrazenie nákupného košíka
        return new RedirectResponse($this->url("shoppingCart.index"));
    }


    public function delete(): Response
    {
        $itemId = (int)$this->request()->getValue('item_id');

        $productInCart = ShoppingCart::getOne($itemId);
        if ($productInCart) {
            $productInCart->delete();
        } else {
            // Produkt neexistuje v košíku
            throw new HTTPException(404);
        }

        // Po odobratí produktu presmeruj na zobrazenie nákupného košíka
        return new RedirectResponse($this->url("shoppingCart.index"));
    }
}
