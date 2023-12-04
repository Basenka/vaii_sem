<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Plant;
use App\Models\User;
use App\Models\Order;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        return true;
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse

    public function index(): Response
    {
        return $this->html();
    }

    /**
     * Example of an action accessible without authorization
     * @return \App\Core\Responses\ViewResponse
     */
    public function contact(): Response
    {
        return $this->html();
    }

    public function catalog(): Response
    {
        return $this->html();
    }

    public function basket(): Response
    {
        return $this->html();
    }

    public function product(): Response
    {
        return $this->html();
    }

    public function registration(): Response
    {
        return $this->html();
    }
    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response
    {
        $plants = Plant::getAll();
        $users = User::getAll();

        return $this->html(
            [
                'plants' => $plants,
                'users' => $users,
            ]
        );
    }


}
