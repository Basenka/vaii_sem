$(document).ready(function () {
    $('#name, #surname').on('input', function () {
        validateField($(this), 'Pole môže obsahovať iba písmená!');
    });
    $('#address').on('input', function () {
        validateAddress();
    });
    $('#password').on('input', function () {
        validatePassword();

    });
    $('#confirm-password').on('input', function () {
        validateConfirmPassword();
    });


    $('#update-form').submit(function (event) {
        event.preventDefault();

        if (!validateForm()) {
            event.preventDefault();
            return;
        }

        var formData = $(this).serialize();
        console.log('Před odesláním AJAX požadavku');
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'), // Získajte akciu z atribútu formulára
            data: formData,
            dataType: 'json',


            success: function (response) {
                console.log('Response:', response);
                if (response.success) {
                    console.log('succes true');
                    // Úspěšná registrácia,presmerovanie
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
        var isNameValid = validateField($('#name'), 'Pole môže obsahovať iba písmená!');
        var isSurnameValid = validateField($('#surname'), 'Pole môže obsahovať iba písmená!');
        var isAddressValid = validateAddress();
        var isPasswordValid = $('#password').val().trim() === '' || validatePassword();

        var isConfirmPasswordValid = validateConfirmPassword();

        return isNameValid && isSurnameValid && isAddressValid && isPasswordValid && isConfirmPasswordValid;
    }


    function validateField(input, errorMessage) {
        var value = input.val();

        if (value.trim() === '') {
            input.next('.error').text('');
            return true;
        } else if (!/^[a-zA-Z]+$/.test(value)) {
            input.next('.error').text(errorMessage);
            return false;
        } else {
            input.next('.error').text('');
            return true;
        }
    }

    function validateAddress() {
        var address = $('#address').val();

        if (address.trim() === '') {
            $('#addressError').text('');
            return true;
        } else if (!/^[a-zA-Z0-9\s]+$/.test(address)) {
            $('#addressError').text('Pole adresa môže obsahovať iba písmená a čísla!');
            return false;
        } else {
            $('#addressError').text('');
            return true;
        }
    }

});