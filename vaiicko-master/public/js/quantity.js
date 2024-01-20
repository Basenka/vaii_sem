var quantityInput = document.getElementById('quantity');
var hiddenQuantityInput = document.getElementById('hiddenQuantity');

function incrementQuantity() {
    var currentQuantity = parseInt(quantityInput.value, 10) || 0;
    quantityInput.value = currentQuantity + 1;
    hiddenQuantityInput.value = quantityInput.value;
}

function decrementQuantity() {
    var currentQuantity = parseInt(quantityInput.value, 10) || 0;
    if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
        hiddenQuantityInput.value = quantityInput.value;
    }
}