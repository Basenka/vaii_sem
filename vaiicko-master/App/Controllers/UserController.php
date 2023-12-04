<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Helpers\FileStorage;
use App\Models\User;

class UserController extends AControllerBase
{
    public function index(): Response
    {
    }


    public function add(): Response
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

        return new RedirectResponse($this->url("home.index"));
    }


    public function save()
    {
        $id = (int)$this->request()->getValue('id');

        //ziskanie uz existujecho uctu
        if ($id > 0) {
            $user = User::getOne($id);

            if (is_null($user)) {
                throw new HTTPException(404);
            }

            // Ulozenie existujuceho username a id
            $originalUsername = $user->getUsername();
            $originalId = $user->getId();
            $emailValue = $this->request()->getValue('email');
            if (!empty($emailValue)) {
                $user->setEmail($emailValue);
            }

            $passwordValue = $this->request()->getValue('password');
            if (!empty($passwordValue)) {
                $user->setPassword($passwordValue);
            }
        } else {
            $user = new User();
            $user->setUsername($this->request()->getValue('username'));
            $user->setEmail($this->request()->getValue('email'));
            $user->setPassword($this->request()->getValue('password'));
        }

        // Nastavujem atributy, ktore sa mozu menit
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

        $formErrors = $this->formErrors();

        if (count($formErrors) > 0) {
            return $this->html(
                [
                    'user' => $user,
                    'errors' => $formErrors
                ]
            );
        } else {
            if ($id > 0) {
                // ak pouzivatel existuje, nastavim atributy na povodne hodnoty
                $user->setUsername($originalUsername);
                $user->setId($originalId);
            }

            $user->save();
            return new RedirectResponse($this->url("user.profile"));
        }
    }



    private function formErrors(): array
    {
        $errors = [];

        $id = (int) $this->request()->getValue('id');
        $username = $this->request()->getValue('username');
        $email = $this->request()->getValue('email');
        $password = $this->request()->getValue('password');
        $confirmPassword = $this->request()->getValue('confirm-password');

        // Kontrola unikátnosti používateľského mena
        if (!$this->isUsernameUnique($id, $username)) {
            $errors[] = "Používateľské meno je už obsadené, použité iné!";
        }

        // Kontrola unikátnosti e-mailu
        if (!$this->isEmailUnique($id, $email)) {
            $errors[] = "Účet s daným e-mailom už existuje!";
        }


        // Kontrola dĺžky hesla
        if (strlen($password) < 8 || strlen($password) > 20) {
            $errors[] = "Heslo musí mať od 8 do 20 znakov!";
        }

        // Kontrola zhody hesla a potvrdenia hesla
        if ($password !== $confirmPassword) {
            $errors[] = "Heslo a potvrdenie hesla sa nezhodujú!";
        }

        return $errors;
    }

    private function isUsernameUnique($id, $username): bool
    {
        $user = User::getByUsername($username);

        if ($user instanceof User) {
            // If the user exists, and the ID is different from the one being edited, return false
            return $user->getId() === $id;
        } else {
            // If the user doesn't exist, or it's the same user being edited, return true
            return true;
        }
    }


    public function isEmailUnique($id, $email): bool
    {
        $user = User::getByEmail($email);

        if ($user instanceof User) {
            // Ak používateľ neexistuje, alebo existuje s rovnakým ID (pre aktualizáciu), vráti true
            return $user === null || ($user instanceof User && $user->getId() === $id);
        } else {
            // Používateľ neexistuje, môžete zvoliť správanie podľa potreby, napr. považovať za unikátne
            return true;
        }
    }




}

