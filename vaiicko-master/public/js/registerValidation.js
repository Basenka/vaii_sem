$(document).ready(function () {


    $('#username').on('input', function () {
        validateUsername();
    });
    $('#email').on('input', function () {
        validateEmail();
    });
    $('#password').on('input', function () {
        validatePassword();
    });
    $('#confirm-password').on('input', function () {
        validateConfirmPassword();
    });


    $('#registration-form').submit(function (event) {
        event.preventDefault();

        if (!validateForm()) {
            event.preventDefault();
            return;
        }

        var formData = $(this).serialize();
        console.log('Před odesláním AJAX požadavku');
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'), // Získanie akciu z atribútu formulára
            data: formData,
            dataType: 'json',


            success: function (response) {
                console.log('Response:', response);
                if (response.success) {
                    console.log('succes true');
                    // Úspěšná registrácia, presmeroavanie
                    window.location.href = response.redirect;
                } else {
                    console.log('AJAX Errors:', response.errors);
                    // Zobrazenie chýb na stránke
                    var errorMessages = [];

                    for (var key in response.errors) {
                        if (response.errors[key]) {
                            errorMessages.push(response.errors[key]);
                        }
                    }

                    if (errorMessages.length > 0) {
                        alert('Chyby: ' + errorMessages.join(', '));
                    } else {
                        alert('Žiadne chyby.');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Nastala chyba pri spracovaní požiadavky.');
            }

        });
    });

    function validateForm() {
        return validateUsername() && validateEmail() && validatePassword() && validateConfirmPassword();
    }

    function validateUsername() {
        var username = $('#username').val();

        if (username.trim() === '') {
            $('#usernameError').text('Pole Používateľské meno musí byť vyplnené!');
            return false;
        } else {
            $('#usernameError').text('');
            return true;
        }
    }

    function validateEmail() {
        var email = $('#email').val();

        if (email.trim() === '' || !isValidEmail(email)) {
            $('#emailError').text('Zadajte platnú e-mailovú adresu!');
            return false;
        } else {
            $('#emailError').text('');
            return true;
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});