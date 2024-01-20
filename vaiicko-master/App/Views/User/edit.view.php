<?php

$layout = 'profile';
/** @var \App\Models\User $user */
/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var Array $errors */
/** @var \App\Core\LinkGenerator $link */


?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="content">
    <h2>Úprava profilu</h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <?php if (@$data['user'] !== null) : ?>
        <form id="update-form" method="post" action="<?= $link->url('user.save') ?>" enctype="multipart/form-data"
              class="my-form">
            <input type="hidden" name="id" value="<?= @$data['user']?->getId() ?>">
            <div class="form-group">
                <label for="name">Meno:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= @$data['user']?->getName() ?>">
                <span id="nameError" class="error"></span>
            </div>

            <div class="form-group">
                <label for="surname">Priezvisko:</label>
                <input type="text" id="surname" name="surname" class="form-control"
                       value="<?= @$data['user']?->getSurname() ?>">
                <span id="surnameError" class="error"></span>
            </div>

            <div class="form-group">
                <label for="address">Adresa:</label>
                <input type="text" id="address" name="address" class="form-control"
                       value="<?= @$data['user']?->getAddress() ?>">
                <span id="addressError" class="error"></span>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control"
                       value="<?= @$data['user']?->getUsername() ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control"
                       value="<?= @$data['user']?->getEmail() ?>">
            </div>

            <div class="form-group">
                <label for="password">Nové heslo:</label>
                <input type="password" id="password" name="password" class="form-control">
                <span id="passwordError" class="error"></span>
                <span id="password-strength"></span>
            </div>

            <div class="form-group">
                <label for="confirm-password">Potvrďte heslo:</label>
                <input type="password" id="confirm-password" name="confirm-password" class="form-control">
                <span id="confirm-password-error" class="error"></span>

            </div>

            <div class="form-group">
                <button type="submit" class="btn mybtn">Uložiť zmeny</button>
                <a href="<?= $link->url('user.delete', ['id' => $data['user']->getId()]) ?>" class="btn btn-danger">Vymazať</a>
            </div>
        </form>

    <?php else : ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>

<script src="../../../public/js/passwordValidation.js"></script>

<script src="../../../public/js/updateUserValidation.js"></script>

