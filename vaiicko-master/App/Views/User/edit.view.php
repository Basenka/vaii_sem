<?php

use App\Models\User;

$layout = 'profile';
/** @var \App\Models\User $user */
/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var Array $errors */
/** @var \App\Core\LinkGenerator $link */


?>

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
        <form method="post" action="<?= $link->url('user.save') ?>" enctype="multipart/form-data" class="my-form">
            <input type="hidden" name="id" value="<?= @$data['user']?->getId() ?>">
            <div class="form-group">
                <label for="name">Meno:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= @$data['user']?->getName() ?>">
            </div>

            <div class="form-group">
                <label for="surname">Priezvisko:</label>
                <input type="text" id="surname" name="surname" class="form-control" value="<?= @$data['user']?->getSurname() ?>">
            </div>

            <div class="form-group">
                <label for="address">Adresa:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?= @$data['user']?->getAddress() ?>">
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?= @$data['user']?->getUsername() ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= @$data['user']?->getEmail() ?>">
            </div>

            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" class="form-control" >
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn mybtn">Uložiť zmeny</button>
                <a href="<?= $link->url('user.delete', ['id' => $data['user']->getId()]) ?>" class="btn btn-danger">Vymazať</a>            </div>
        </form>

    <?php else : ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var passwordInput = document.getElementById('password');
        var confirmPasswordInput = document.getElementById('confirm-password');

        passwordInput.addEventListener('input', function () {
            // Make the "Confirm Password" field required only if a new password is entered
            confirmPasswordInput.required = passwordInput.value.trim().length > 0;
        });

        // Initial check when the page loads
        confirmPasswordInput.required = passwordInput.value.trim().length > 0;
    });
</script>