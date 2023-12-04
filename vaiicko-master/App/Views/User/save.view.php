
<?php
$layout = 'auth';
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
        <form class="my-form login-form">
            <h3>Prihlásenie</h3>
            <div class="form-group">
                <label for="login-username">Používateľské meno:</label>
                <input type="text" id="login-username" name="login-username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="login-password">Heslo:</label>
                <input type="password" id="login-password" name="login-password" class="form-control" required>
            </div>

            <input type="submit" value="Prihlásiť sa" class="btn mybtn btn-primary">
        </form>

        <div class="vertical-line"></div> <!-- Zvislý oddelovač -->

        <form method="post" action="<?= $link->url('user.save') ?>" class="my-form registration-form" enctype="multipart/form-data">
            <h3>Registrácia</h3>
            <div class="form-group">
                <label for="username">Používateľské meno:</label>
                <input type="text" id="username" name="username" class="form-control" required>
                <div id="username-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <div id="email-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="password">Heslo:</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" id="toggle-password" class="toggle-password"><i class="bi bi-eye"></i></button>
                </div>
                <div id="password-error" class="error-message"></div>
                <div id="password-strength"></div>
            </div>
            <div class="form-group">
                <label for="confirm-password">Potvrďte heslo:</label>
                <input type="password" id="confirm-password" name="confirm-password" class="form-control" required>
                <div id="confirm-password-error" class="error-message"></div>
            </div>

            <input type="submit" value="Registrovať sa" class="btn mybtn btn-primary">
        </form>
    </div>
</div>

<!-- script na kontrolu podmienok na strane klienta-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var usernameInput = document.getElementById('username');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var confirmPasswordInput = document.getElementById('confirm-password');

        usernameInput.addEventListener('input', validateUsername);
        emailInput.addEventListener('input', validateEmail);
        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validateConfirmPassword);

        function validateUsername() {
            var username = usernameInput.value;
            var usernameError = document.getElementById('username-error');

            if (username.trim() === '') {
                usernameError.textContent = 'Pole Používateľské meno musí byť vyplnené!';
            } else {
                usernameError.textContent = '';
            }
        }

        function validateEmail() {
            var email = emailInput.value;
            var emailError = document.getElementById('email-error');

            if (email.trim() === '' || !isValidEmail(email)) {
                emailError.textContent = 'Zadajte platnú e-mailovú adresu!';
            } else {
                emailError.textContent = '';
            }
        }

        function validatePassword() {
            var password = passwordInput.value;
            var passwordError = document.getElementById('password-error');
            var passwordStrength = document.getElementById('password-strength');

            var uppercase = /[A-Z]/.test(password);
            var lowercase = /[a-z]/.test(password);
            var number = /\d/.test(password);
            var specialChar = /[^\w\d]/.test(password);

            var isUppercase = uppercase ? '✔' : '✘';
            var isLowercase = lowercase ? '✔' : '✘';
            var isNumber = number ? '✔' : '✘';
            var isSpecialChar = specialChar ? '✔' : '✘';
            var isLength = password.length >= 8 && password.length <= 20 ? '✔' : '✘';

            var passwordStrengthMessage = `
        Veľké písmeno: ${isUppercase}<br>
        Malé písmeno: ${isLowercase}<br>
        Číslo: ${isNumber}<br>
        Špeciálny znak: ${isSpecialChar}<br>
        Dĺžka (8-20 znakov): ${isLength}
    `;

            passwordStrength.innerHTML = passwordStrengthMessage;

            if (!uppercase || !lowercase || !number || !specialChar || password.length < 8 || password.length > 20) {
                passwordError.textContent = 'Heslo nespĺňa všetky požadované podmienky.';
            } else {
                passwordError.textContent = '';
            }
        }


        function validateConfirmPassword() {
            var confirmPassword = confirmPasswordInput.value;
            var confirmPasswordError = document.getElementById('confirm-password-error');

            if (confirmPassword !== passwordInput.value) {
                confirmPasswordError.textContent = 'Heslo a potvrdenie hesla sa nezhodujú!';
            } else {
                confirmPasswordError.textContent = '';
            }
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    });


    //zobrazovanie a skryvanie hesla
    document.addEventListener('DOMContentLoaded', function () {
        var passwordInput = document.getElementById('password');
        var togglePasswordButton = document.getElementById('toggle-password');

        togglePasswordButton.addEventListener('click', function () {
            // Zmena typu vstupného pola medzi "password" a "text"
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';

            // Zmena textu na tlačidle podľa typu pola
            togglePasswordButton.innerHTML = passwordInput.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i></i>';
        });
    });
</script>

