<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{

    public function index(): Response
    {
        $products = Product::getAll();
        $users = User::getAll();

        return $this->html(
            [
                'products' => $products,
                'users' => $users,
            ]
        );
    }


}
