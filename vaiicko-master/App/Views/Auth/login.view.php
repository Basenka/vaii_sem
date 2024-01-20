<?php
//$layout = 'auth';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
if (!is_null(@$data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="content-container form-container">
    <div class="forms-wrapper">
        <form class="my-form login-form" method="post" action="<?= $link->url("login") ?>">
            <h3>Prihlásenie</h3>
            <?= @$data['message'] ?>
            <!--skryte pole pre nastavanie role_id na id zakaznika-->
            <input type="hidden" name="role" value="customer">
            <div class="form-group">
                <label for="username">Používateľské meno:</label>
                <input type="text" id="login" name="login" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Heslo:</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" id="toggle-password" class="toggle-password"><i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button class="btn mybtn btn-primary" type="submit" name="submit">Prihlásiť</button>
            <a href="<?=$link->url('user.add');?>" class="btn mybtn">Registrácia</a>
        </form>
    </div>
</div>


<script src="../../../public/js/showPassword.js"></script>

