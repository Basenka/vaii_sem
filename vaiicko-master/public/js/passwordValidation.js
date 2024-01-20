function validatePassword() {
    var password = $('#password').val();
    var passwordStrength = $('#password-strength');

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
        <br>Veľké písmeno: ${isUppercase}<br>
        Malé písmeno: ${isLowercase}<br>
        Číslo: ${isNumber}<br>
        Špeciálny znak: ${isSpecialChar}<br>
        Dĺžka (8-20 znakov): ${isLength}
    `;
    passwordStrength.html(passwordStrengthMessage);

    if (!uppercase || !lowercase || !number || !specialChar || password.length < 8 || password.length > 20) {
        $('#passwordError').text('Vaše heslo je slabé.');
        return true;
    } else {
        $('#passwordError').text('Vaše heslo je silné.');
        return true;
    }
}

function validateConfirmPassword() {
    var confirmPassword = $('#confirm-password').val();

    if (confirmPassword !== $('#password').val()) {
        $('#confirm-password-error').text('Heslo a potvrdenie hesla sa nezhodujú!');
        return false;
    } else {
        $('#confirm-password-error').text('');
        return true;
    }
}