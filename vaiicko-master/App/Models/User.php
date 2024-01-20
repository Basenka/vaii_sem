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
    protected ?string $role;
    protected ?string $salt;


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

    public function setPassword(?string $password): void
    {
        if ($password !== null) {
            $salt = bin2hex(random_bytes(16)); // Vygeneruj random salt
            $hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT); //zahashuj haslo
            $this->password = $hashedPassword;
            $this->setSalt($salt);
        }
    }




    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setRole($role) : void
    {
        $this->role = $role;
    }

    public function getRole() : ?string
    {
        return $this->role;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }


}
