<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/styl.css">
    <script src="public/js/script.js"></script>
</head>
<body>

<div class="header">
    <div class="header-container">
        <i class="bi bi-instagram"></i>
        <i class="bi bi-facebook"></i>
    </div>

</div>

<div class="logosearch">
    <a class="logo-link" href="<?= $link->url("home.index") ?>"  >
        <img src="public/images/plantorea_logo.png" alt="Logo Plantorea">
    </a>
    <input type="text" placeholder="Vyhľadávanie...">
    <button type="submit"><i class="bi bi-search-heart"></i></button>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url("home.catalog") ?>">Rastliny</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url("home.contact") ?>">Kvetináče</a>
                </li>
            </ul>
            <?php if ($auth->isLogged()) { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $auth->getLoggedUserName() ?> <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= $link->url("user.profile") ?>">Zobraziť profil</a></li>
                            <li><a class="dropdown-item" href="<?= $link->url("auth.logout") ?>">Odhlásenie</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Košík <i class="bi bi-basket-fill"></i></a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \App\Config\Configuration::LOGIN_URL ?>">Prihlásenie <i
                                    class="bi bi-person"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url("home.basket") ?>">Košík <i class="bi bi-basket-fill"></i></a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>

</body>


</html>
