<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\Response;

class AdminController extends AControllerBase
{
    //metoda authorize vráti true len ak je prihlásený admin
    public function authorize($action)
    {
        $user = $this->app->getAuth()->getLoggedUserContext();
        return $user->getRole() == 'admin';
    }

    public function index(): Response
    {
        if ($this->authorize('index')) {
            return $this->html();
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }


    public function users(): Response
    {
        if ($this->authorize('users')) {
            $users = \App\Models\User::getAll();
            return $this->html(['users'=>$users]);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }

    public function addUser() : Response
    {
        if ($this->authorize('addUser')) {
            return $this->html();
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }
    }
    public function addProduct() : Response
    {
        if ($this->authorize('addProduct')) {
            return $this->html();
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }
    }

    public function products() : Response
    {
        if ($this->authorize('products')) {
            $products = \App\Models\Product::getAll();
            return $this->html(['products'=>$products]);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }
    public function order() : Response
    {
        if ($this->authorize('order')) {
            $orders = \App\Models\Order::getAll();
            return $this->html(['orders'=>$orders]);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }
    public function orderDetails() : Response
    {
        if ($this->authorize('orderDetails')) {
            $id = $this->request()->getValue('id');
            $order = \App\Models\Order::getone($id);
            $orderItems = \App\Models\OrderItem::getAll();
            return $this->html(['orderItems'=>$orderItems, 'order'=>$order, 'orderId'=>$id]);
        }
        else {
            throw new HttpException(404, 'Page not Found');
        }

    }
}
