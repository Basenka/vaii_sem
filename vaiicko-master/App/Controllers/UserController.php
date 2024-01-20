<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\User;
use App\Validators\UserValidator;

class UserController extends AControllerBase
{
    public function authorize($action): bool
    {
        $user = $this->app->getAuth()->getLoggedUserContext();
        switch ($action) {
            case 'index' :
            case 'add':
            case 'registrationSuccessful':
            case 'deleted':
            case 'save':
                return true;

            case 'orders' :
            case 'profile' :
            case 'edit':
            case 'delete' :
                return $this->app->getAuth()->isLogged();

            case 'filtered':
            case 'all' :
                return $user->getRole() == 'admin' or $user->getRole() == 'employee';

            default:
                return false;
        }
    }
    public function index(): Response
    {
    }

    public function filtered(): JsonResponse
    {
        $filterValue = $this->request()->getValue('filter');
        $filterColumn = $this->request()->getValue('column');

        $allowedColumns = ['username', 'email', 'name', 'surname', 'role', 'address' ];
        if (!in_array($filterColumn, $allowedColumns)) {
            // Neplatný stĺpec
            return new JsonResponse(['error' => 'Neplatný stĺpec pre filtrovanie']);
        }
        $filteredUsers = \App\Models\User::getFiltered([$filterColumn => $filterValue]);
        return new JsonResponse($filteredUsers);
    }

    public function all() : JsonResponse
    {
        $users = \App\Models\User::getAll();
        return new JsonResponse($users);
    }

    public function add(): Response
    {
        return $this->html();
    }
    public function registrationSuccessful(): Response
    {
        return $this->html();
    }
    public function deleted(): Response
    {
        return $this->html();
    }
    public function profile(): Response
    {

        $id = (int)$this->request()->getValue('id');
        $user = User::getOne($id);

        return $this->html(
            [
                'user' => $user
            ]
        );
    }

    public function orders(): Response
    {
        $user = $this->app->getAuth()->getLoggedUserContext();
        $filteredOrders = \App\Models\Order::getFiltered(['user_id' => $user->getId()]);
        return $this->html(
            [
                'orders' => $filteredOrders
            ]
        );

    }

    public function edit(): Response
    {
        $id = (int)$this->request()->getValue('id');
        $user = User::getOne($id);

        if (is_null($user)) {
            throw new HTTPException(404);
        }

        return $this->html(
            [
                'user' => $user
            ]
        );
    }

    public function delete(): Response
    {
        $id = (int)$this->request()->getValue('id');
        $user = User::getOne($id);

        if (is_null($user)) {
            throw new HTTPException(404);
        }

        $this->app->getAuth()->logout();
        $user->delete();

        return new RedirectResponse($this->url("user.deleted"));
    }


    public function save(): JsonResponse
    {
        $id = (int) $this->request()->getValue('id');

        $validator = new UserValidator();

        if ($id > 0) {
            $user = User::getOne($id);
        } else {
            $user = new User();
            $user->setRole($this->request()->getValue('role'));
        }

        // Validacia uživatelského mena
        $username = $this->request()->getValue('username');
        $usernameError = $validator->validateUsername($id, $username);

        // Validacia mailu
        $email = $this->request()->getValue('email');
        $emailError = $validator->validateEmail($id, $email);

        // Validacia hesla

        $password = $this->request()->getValue('password');
        $confirmPassword = $this->request()->getValue('confirm-password');
        $passwordErrors = ($password !== '' || $confirmPassword !== '') ? $validator->validatePassword($password, $confirmPassword) : [];

        // Validace mena, priezviska a adresy iba ak su zadane hodnoty
        $name = $this->request()->getValue('name');
        $nameError = (!empty($name)) ? $validator->validateName($name) : '';

        $surname = $this->request()->getValue('surname');
        $surnameError = (!empty($surname)) ? $validator->validateSurname($surname) : '';

        $address = $this->request()->getValue('address');
        $addressError = (!empty($address)) ? $validator->validateAddress($address) : '';

        // zoznam validacnych chyb
        $formErrors = compact('usernameError', 'emailError', 'passwordErrors', 'nameError', 'surnameError', 'addressError');

        $response = ['success' => false, 'errors' => $formErrors];

        if (empty(array_filter($formErrors))) {
            // Validacia prešla

            // Nastavenie hodnot
            $user->setUsername($username);
            $user->setEmail($email);
            if(!($id > 0) || $password = $this->request()->getValue('password') !== '') {
                $user->setPassword($password);
            }

            $nameValue = $this->request()->getValue('name');
            if (!empty($nameValue)) {
                $user->setName($nameValue);
            }

            $surnameValue = $this->request()->getValue('surname');
            if (!empty($surnameValue)) {
                $user->setSurname($surnameValue);
            }

            $address = $this->request()->getValue('address');
            if (!empty($address)) {
                $user->setAddress($address);
            }

            $user->save();

            $response['success'] = true;
            if($id > 0) {
                $response['redirect'] = $this->url("user.profile");
            }else {
                $response['redirect'] = $this->url("user.registrationSuccessful");
            }

        }

        return new JsonResponse($response);
    }




}

