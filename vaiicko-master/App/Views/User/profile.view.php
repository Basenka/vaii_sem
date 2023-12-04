<?php
$layout = 'profile';
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Models\User $user */
/** @var \App\Core\LinkGenerator $link */

$user = $auth->getLoggedUserContext();

 ?>


<!-- Content -->
<div class="content">
    <h2>Tvoj Profil</h2>

    <div>
        <strong>Meno:</strong> <?= $user->getName() ?? 'N/A' ?>
    </div>
    <div>
        <strong>Priezvisko:</strong> <?= $user->getSurname() ?? 'N/A' ?>
    </div>
    <div>
        <strong>Používateľské meno:</strong> <?=$user->getUsername() ?? 'N/A' ?>
    </div>
    <div>
        <strong>Email:</strong> <?= $user->getEmail() ?? 'N/A' ?>
    </div>
    <div>
        <strong>Adresa:</strong> <?= $user->getAddress() ?? 'N/A' ?>
    </div>

    <a href="<?= $link->url('user.edit', ['id' => $user->getId()]) ?>" class="btn mybtn mt-3">Upraviť</a>

    <a href="<?= $link->url('auth.logout') ?>" class="btn mybtn mt-3">Odhlásiť</a>
</div>
