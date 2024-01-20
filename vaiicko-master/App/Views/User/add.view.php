<?php
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
/** @var \App\Core\IAuthenticator $auth */
if (!is_null(@$data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="content-container form-container">
    <div class="forms-wrapper">
        <form  id="registration-form" method="post" action="<?= $link->url('user.save') ?>" class="my-form registration-form"
              enctype="multipart/form-data">
            <?php if ($auth->isLogged()) : ?>
                <h3>Pridať používateľa</h3>
            <?php else: ?>
                <h3>Registrácia</h3>
            <?php endif; ?>

            <!--skryte pole pre nastavanie role_id na id zakaznika-->
            <input type="hidden" id="role" name="role" value="customer">
            <div class="form-group">
                <label for="username">Používateľské meno:</label>
                <input type="text" id="username" name="username" class="form-control" required>
                <span id="usernameError" class="error"></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <span id="emailError" class="error"></span>
            </div>

            <div class="form-group">
                <label for="password">Heslo:</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" id="toggle-password" class="toggle-password"><i class="bi bi-eye"></i>
                    </button>
                </div>
                <span id="passwordError" class="error"></span>
                <span id="password-strength"></span>
            </div>
            <div class="form-group">
                <label for="confirm-password">Potvrďte heslo:</label>
                <div class="password-input-container">
                    <input type="password" id="confirm-password" name="confirm-password" class="form-control" required>
                    <button type="button" id="toggle-confirm-password" class="toggle-confirm-password"><i
                                class="bi bi-eye"></i></button>
                </div>
                <span id="confirm-password-error" class="error"></span>
            </div>

            <?php if ($auth->isLogged()) :
                $role = $auth->getLoggedUserContext()->getRole();
                if ($role == 'admin' || $role == 'employee') : ?>
                    <div class="form-group">
                        <label for="role">Rola:</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="customer">Zákazník</option>
                            <option value="employee">Zamestnanec</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                <?php endif;
            endif; ?>

            <input type="submit" value="Registrovať sa" class="btn mybtn btn-primary">
        </form>
    </div>
</div>

<script src="../../../public/js/passwordValidation.js"></script>
<script src="../../../public/js/registerValidation.js"></script>
<script src="../../../public/js/showPassword.js"></script>

