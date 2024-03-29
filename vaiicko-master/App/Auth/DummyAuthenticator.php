<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\User;

/**
 * Class DummyAuthenticator
 * Basic implementation of user authentication
 * @package App\Auth
 */
class DummyAuthenticator implements IAuthenticator
{
    public const LOGIN = "admin";
    public const PASSWORD_HASH = '$2y$10$GRA8D27bvZZw8b85CAwRee9NH5nj4CQA6PDFMc90pN9Wi4VAWq3yq'; // admin
    public const USERNAME = "Admin";

    /**
     * DummyAuthenticator constructor
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Verify if the user is in DB and has his password correct
     * @param string $login
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    //upravená metóda login pre prihlasenie pomocou databázy
    public function login($login, $password): bool
    {
        $user = User::getByUsername($login);

        if ($user instanceof User && password_verify($password . $user->getSalt(), $user->getPassword())) {
            // Heslo bolo verifkovane, nastav session
            $_SESSION['user'] = $user->getUsername();
            return true;
        } else {
            // Neplatné prihlásenie
            return false;
        }
    }


    /**
     * Logout the user
     */
    public function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            session_regenerate_id(true);
            session_destroy();
        }
    }

    /**
     * Get the name of the logged-in user
     * @return string
     */
    public function getLoggedUserName(): string
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : throw new \Exception("User not logged in");
    }

    /**
     * Get the context of the logged-in user
     * @return string
     */
    public function getLoggedUserContext(): ?User
    {
        if ($this->isLogged()) {
            // Assuming you store more than just the username in the session
            $username = $_SESSION['user'];
            return User::getByUsername($username);
        }

        return null;
    }

    /**
     * Return if the user is authenticated or not
     * @return bool
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user'] != null;
    }

    /**
     * Return the id of the logged-in user
     * @return mixed
     */
    public function getLoggedUserId(): mixed
    {
        return $_SESSION['user'];
    }

}
