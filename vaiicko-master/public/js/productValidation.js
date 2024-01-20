$(document).ready(function() {
    console.log('Document is ready');
    var formSubmitted = false;
    // listener pre real-time validaciu
    $('#name').on('input', function() {
        validateName();
    });

    $('#picture').on('change', function() {
        if ($('#picture').val()) {  // Kontrola, či je políčko s obrázkom vyplnené alebo vybraté
            validatePicture();
        } else {
            $('#imageError').text('Obrázok produktu je povinný.');  // Validácia pre prípad, ak nie je vybraný obrázok
        }
    });

    $('#description').on('input', function() {
        validateDescription();
    });

    $('#care').on('input', function() {
        validateCare();
    });

    $('#price').on('input', function() {
        validatePrice();
    });

    // Zachytávanie odoslania formulára pomocou AJAX
    $('#productForm').submit(function(event) {
        event.preventDefault();

        // Nastavenie príznaku, že formulár bol odoslaný
        formSubmitted = true;

        if (!validateForm()) {
            event.preventDefault(); // prevencia pred odoslanim ak data nie su validne
            return;
        }

        console.log('Form submit event triggered');
        // Vytvorenie formData objektu pre odoslanie súborov AJAX-om
        var formData = new FormData($(this)[0]);
        console.log('FormData:', formData);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json', // Očakávam JSON odpoveď

            success: function(response) {
                console.log('Response:', response);

                if (response.success) {
                    // Presmerovanie na úspech
                    window.location.href = response.redirect;
                } else {
                    // Zobrazenie chýb na stránke
                    var errorMessages = [];

                    // iteracia cez kluce v response.errors
                    for (var key in response.errors) {
                        if (response.errors[key]) {
                            // pridanie chybovej spravy do pola
                            errorMessages.push(response.errors[key]);
                        }
                    }

                    if (errorMessages.length > 0) {
                        // spojenie chybovych sprav a ich vypis
                        alert('Chyby: ' + errorMessages.join(', '));
                    } else {
                        alert('Žiadne chyby.');
                    }
                }
            },


            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Nastala chyba pri spracovaní požiadavky.');
            }
        });
    });

    function validateForm() {
        var isValid = true;

        isValid = validateName() && isValid;
        isValid = validatePicture() && isValid;
        isValid = validateDescription() && isValid;
        isValid = validateCare() && isValid;
        isValid = validatePrice() && isValid;

        return isValid;
    }
    function validateName() {
        var name = $('#name').val();
        var disallowedChars = /[!@#$%^&*()_+={}[\]:;<>,.?~\\/-]/;
        var minLength = 3;
        var maxLength = 50;

        if (name.trim() === '') {
            $('#nameError').text('Názov produktu je povinný.');
            return false;
        } else if (disallowedChars.test(name)) {
            $('#nameError').text('Názov produktu nemôže obsahovať špeciálne znaky.');
            return false;
        } else if (name.length < minLength || name.length > maxLength) {
            $('#nameError').text('Názov produktu musí byť medzi ' + minLength + ' a ' + maxLength + ' znakmi.');
            return false;
        } else {
            $('#nameError').text('');
            return true;
        }
    }



    function validatePicture() {
        var fileInput = $('#picture')[0];
        var file = fileInput.files[0];

        // Ak sa pridáva nový produkt, obrázok je povinný
        if (!$('#id').val() && !file) {
            $('#imageError').text('Obrázok produktu je povinný.');
            return false;
        }

        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(file.name)) {
            $('#imageError').text('Nepovolený formát obrázka. Povolené sú len súbory s koncovkami .jpg, .jpeg a .png.');
            return false;
        }

        // Ak je všetko v poriadku
        $('#imageError').text('');
        return true;
    }

    function validateDescription() {
        var description = $('#description').val();
        var minLength = 10;
        var maxLength = 800;

        if (description.trim() === '') {
            $('#descriptionError').text('Popis produktu je povinný.');
            return false;
        } else if (description.length < minLength || description.length > maxLength) {
            $('#descriptionError').text('Popis produktu musí byť medzi ' + minLength + ' a ' + maxLength + ' znakmi.');
            return false;
        } else {
            $('#descriptionError').text('');
            return true;
        }
    }

    function validateCare() {
        var care = $('#care').val();
        var minLength = 10;
        var maxLength = 1500;

        if (care.trim() === '') {
            $('#careError').text('Starostlivosť o produkt je povinná.');
            return false;
        } else if (care.length < minLength || care.length > maxLength) {
            $('#careError').text('Starostlivosť o produkt musí byť medzi ' + minLength + ' a ' + maxLength + ' znakmi.');
            return false;
        } else {
            $('#careError').text('');
            return true;
        }
    }

    function validatePrice() {
        var price = $('#price').val();
        var minValue = 0;
        var maxValue = 1000;

        if (price.trim() === '') {
            $('#priceError').text('Cena produktu je povinná.');
            return false;
        } else if (isNaN(price) || parseFloat(price) < minValue || parseFloat(price) > maxValue) {
            $('#priceError').text('Cena produktu musí byť číslo medzi ' + minValue + ' a ' + maxValue + '.');
            return false;
        } else {
            $('#priceError').text('');
            return true;
        }
    }

});