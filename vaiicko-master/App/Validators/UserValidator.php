<?php

namespace App\Validators;

use App\Models\User;

class UserValidator
{
    public function validateUsername($id, $username): string
    {
        // Kontrola prázdného uživatelského mena
        if (empty($username)) {
            return 'Pole Používateľské meno musí byť vyplnené!';
        }

        // Validacia unikatnosti mena
        $user = User::getByUsername($username);

        if ($user instanceof User) {
            return ($user->getId() === $id) ? '' : 'Používateľské meno je už obsadené, použite iné!';
        } else {
            return '';
        }
    }

    public function validateEmail($id, $email): string
    {
        // Kontrola prázdného e-mailu
        if (empty($email)) {
            return 'Pole Email musí byť vyplnené!';
        }

        // Validacia unikátnosti e-mailu
        $user = User::getByEmail($email);

        if ($user instanceof User) {
            return ($user->getId() === $id) ? '' : 'Účet s daným e-mailom už existuje!';
        } else {
            return '';
        }
    }

    public function validatePassword($password, $confirmPassword): array
    {
        $errors = [];

        // Kontrola prázdného hesla
        if (empty($password)) {
            $errors[] = 'Pole Heslo musí byť vyplnené!';
        }

        // Kontrola dlzky hesla
        if (strlen($password) < 8 || strlen($password) > 20) {
            $errors[] = 'Heslo musí mať od 8 do 20 znakov!';
        }

        // Kontrola zhody hesla a potvrdenia hesla
        if ($password !== $confirmPassword) {
            $errors[] = 'Heslo a potvrdenie hesla se nezhodujú!';
        }

        return $errors;
    }

    public function validateName($name): string
    {
        // Kontrola nepovolených znakov v mene
        if (!preg_match('/^[a-zA-Z]+$/', $name)) {
            return 'Pole Meno môže obsahovať iba písmená!';
        }

        return '';
    }

    public function validateSurname($surname): string
    {
        // Kontrola nepovolených znakov v priezvisku
        if (!preg_match('/^[a-zA-Z]+$/', $surname)) {
            return 'Pole Priezvisko môže obsahovať iba písmená!';
        }

        return '';
    }

    public function validateAddress($address): string
    {
        // Kontrola nepovolených znakov v adrese
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $address)) {
            return 'Pole Adresa môže obsahovať iba písmená a čísla!';
        }

        return '';
    }

}
