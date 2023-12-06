document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('password');
    var togglePasswordButton = document.getElementById('toggle-password');

    togglePasswordButton.addEventListener('click', function () {
        // Zmena typu vstupného pola medzi "password" a "text"
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';

        // Zmena textu na tlačidle podľa typu pola
        togglePasswordButton.innerHTML = passwordInput.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i></i>';
    });

    var registrationPasswordInput = document.getElementById('register-password');
    var toggleRegistrationPasswordButton = document.getElementById('toggle-register-password');

    toggleRegistrationPasswordButton.addEventListener('click', function () {
        // Zmena typu vstupného pola medzi "password" a "text"
        registrationPasswordInput.type = registrationPasswordInput.type === 'password' ? 'text' : 'password';

        // Zmena textu na tlačidle podľa typu pola
        toggleRegistrationPasswordButton.innerHTML = registrationPasswordInput.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i></i>';
    });

    var confirmPasswordInput = document.getElementById('confirm-password');
    var toggleConfirmPasswordButton = document.getElementById('toggle-confirm-password');

    toggleConfirmPasswordButton.addEventListener('click', function () {
        // Zmena typu vstupného pola medzi "password" a "text"
        confirmPasswordInput.type = confirmPasswordInput.type === 'password' ? 'text' : 'password';

        // Zmena textu na tlačidle podľa typu pola
        toggleConfirmPasswordButton.innerHTML = confirmPasswordInput.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i></i>';
    });
});


    //nastavi confirm heslo ako Required ak je zadane heslo
    document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('register-password');
    var confirmPasswordInput = document.getElementById('confirm-password');

    passwordInput.addEventListener('input', function () {
    confirmPasswordInput.required = passwordInput.value.trim().length > 0;
});

    confirmPasswordInput.required = passwordInput.value.trim().length > 0;
});
