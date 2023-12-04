<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected ?int $id = null;
    protected ?string $name;
    protected ?string $surname;
    protected ?string $username;
    protected ?string $email;
    protected ?string $password;
    protected ?string $address;

    // Getter and setter methods for attributes

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
      $this->id = $id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        // Kontrola délky hesla před zahashováním
        $passwordLength = strlen($password);
        if ($passwordLength < 8 || $passwordLength > 20) {
            throw new \Exception("Heslo musí mít od 8 do 20 znaků!");
        }

        // Zahashování hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function save(): void
    {
        // Pred uložením modelu môžete vykonať vaše vlastné validácie.
        $this->validate();

        // Voláme metódu save z predka, ktorá vykoná vlastné uloženie modelu do databázy.
        parent::save();
    }


    private function validate(): void
    {
        $this->validateUniqueUsername();
        $this->validateUniqueEmail();

    }

    private function validateUniqueUsername(): void
    {
        // Check if $this->username is initialized before accessing it
        if (!isset($this->username)) {
            throw new \Exception("Používateľské meno nie je inicializované!");
        }

        $existingUser = self::getByUsername($this->username);
        if ($existingUser !== false) {
            if ($existingUser->getId() !== $this->getId()) {
                throw new \Exception("Používateľské meno je už registrované!");
            }
        }
    }


    private function validateUniqueEmail(): void
    {
        $existingUser = self::getByEmail($this->email);
        if ($existingUser !== false) {
            if ($existingUser->getId() !== $this->getId()) {
                throw new \Exception("E-mail je už registrovaný!");
            }
        }
    }



}
