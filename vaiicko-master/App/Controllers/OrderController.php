<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Exception;

class OrderController extends AControllerBase
{
    public function authorize($action): bool
    {
        $user = $this->app->getAuth()->getLoggedUserContext();
        switch ($action) {
            case 'filtered':
            case 'index' :
            case 'save':
                return $this->app->getAuth()->isLogged();

            case 'all' :
            case 'edit':
                return $user->getRole() == 'admin' or $user->getRole() == 'employee';

            case 'delete' :
                return $user->getRole() == 'admin';
            default:
                return false;
        }
    }
    public function index(): Response
    {
        if ($this->authorize('index')) {
            $orders = \App\Models\Order::getAll();
            return $this->html(['orders'=>$orders]);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    //tato metoda vracia filtrovane objednavky
    public function filtered(): JsonResponse
    {
        if ($this->authorize('filtered')) {
            $filterValue = $this->request()->getValue('filter');
            $filterColumn = $this->request()->getValue('column');


            $allowedColumns = ['user_id', 'date', 'total_price', 'status' ];
            if (!in_array($filterColumn, $allowedColumns)) {
                return new JsonResponse(['error' => 'Neplatný stĺpec pre filtrovanie']);
            }

            $filteredOrders = \App\Models\Order::getFiltered([$filterColumn => $filterValue]);


            return new JsonResponse($filteredOrders);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    //vracia vsetky obejdnavky ako Json response
    public function all() : JsonResponse
    {
        if ($this->authorize('all')) {
            $orders = \App\Models\Order::getAll();
            return new JsonResponse($orders);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }
    //editovanie objednavky, editovat je mozne len status
    public function edit() : Response
    {
        if ($this->authorize('edit')) {
            $data = $this->request()->getPost();
            $id = $data['id'];
            $status = $data['orderStatus'];
            $order = \App\Models\Order::getOne($id);
            $order->setStatus($status);
            $order->save();
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

        return new RedirectResponse($this->url("admin.order"));
    }

    //metoda na ulozenie objednavky
    public function save()
    {
        if ($this->authorize('save')) {
            try {
                // ziskanie dat z json poziadavky ako asociativne pole
                $data = json_decode(file_get_contents('php://input'), true);

                $totalPrice = $data['totalPrice'];

                $user = $this->app->getAuth()->getLoggedUserContext();
                $dt = new \DateTime();
                $dt->setTimezone(new \DateTimeZone('Europe/Bratislava'));

                $order = new Order();
                $order->setDate($dt->format('Y-m-d H:i:s'));
                $order->setStatus('new');
                $order->setUserId($user->getId());
                $order->setTotalPrice($totalPrice);
                $order->save();


                return new JsonResponse(['success' => true, 'orderId' => $order->getId()]);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()]);
            }
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }


    }

    public function delete(): Response
    {
        if ($this->authorize('delete')) {
            $id = (int)$this->request()->getValue('id');
            $order = Order::getOne($id);

            if (is_null($order)) {
                throw new HTTPException(404);
            }

            $orderItems = OrderItem::getAll();
            foreach ($orderItems as $item) {
                if($item->getOrderId() == $id) {
                    $item->delete();
                }
            }
            $order->delete();

            return new RedirectResponse($this->url("admin.order"));
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }
}
