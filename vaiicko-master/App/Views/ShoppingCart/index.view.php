<?php
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */

$orderItemsArray = [];
?>
<div class="content-container">
    <div class="row">
        <div class="col-12">

            <h2>Košík</h2>
            <?php $totalPrice = 0; ?>
            <?php foreach ($data['cartItems'] as $cartItem):
                $product = \App\Models\Product::getOne($cartItem->getProductId());

                if ($auth->isLogged()) {
                    $user = $auth->getLoggedUserContext();
                    if ($user->getId() != $cartItem->getUserId()) {
                        continue;
                    }
                } else {
                    if (session_id() != $cartItem->getSessionId()) {
                        continue;
                    }
                }

                ?>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">

                                <?php $orderItemsArray[] = $cartItem; ?>
                                <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $product->getImage() ?>"
                                     alt="Item Image" class="me-3"
                                     style="max-width: 100px;">

                                <div class="col-2">
                                    <h5 class="card-title"><?= $product->getName(); ?></h5>
                                </div>
                                <div class="col-1">
                                    <p class="card-text"><?= $product->getPrice() . '€'; ?></p>

                                </div>

                                <div class="input-group">
                                    <button class="btn btn-outline-secondary minus-button" type="button" onclick="decrementQuantity()">-</button>
                                    <input type="text" class="form-control quantity-input" id="quantity" value="<?= $cartItem->getQuantity(); ?>" aria-label="Quantity" style="max-width: 35px;">
                                    <button class="btn btn-outline-secondary plus-button" type="button" onclick="incrementQuantity()">+</button>
                                </div>
                                <?php $totalPrice += $cartItem->getQuantity() * $product->getPrice(); ?>
                                <a href="<?= $link->url('shoppingCart.delete', ['item_id' => $cartItem->getId()]) ?>"
                                   class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="row mb-3">
                <div class="col-12">
                    <h4>Celková cena: <?= $totalPrice ?>€</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="<?= $link->url("home.index") ?>" class="btn mybtn">Pokračovať v nákupe</a>
                    <button type="button" class="btn mybtn" id="checkoutButton">Objednať</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="../../../public/js/quantity.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('checkoutButton').addEventListener('click', function () {
            createOrder();
        });
    });

    function createOrder() {

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= $link->url('order.save') ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function () {
            if (xhr.status === 200) {

                var response = JSON.parse(xhr.responseText);


                if (response.success) {

                    console.log('Order created successfully. Order ID:', response.orderId);
                    saveOrderItems(response.orderId);
                } else {
                    console.error('Error creating order. Response:', response);
                }
            } else {
                console.error('Error creating order. Status:', xhr.status);
            }
        };

        var data = {
            totalPrice: <?= $totalPrice ?>
        };

        xhr.send(JSON.stringify(data));
    }


    function saveOrderItems(orderId) {

        var orderItems = [];
        <?php foreach ($orderItemsArray as $cartItem): ?>
        orderItems.push({
            productId: <?= $cartItem->getProductId(); ?>,
            quantity: <?= $cartItem->getQuantity(); ?>,
            price: <?= $cartItem->getPrice(); ?>,
            itemId: <?= $cartItem->getId(); ?>
        });
        <?php endforeach; ?>

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= $link->url('orderItem.save') ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onload = function () {
            if (xhr.status === 200) {
                  window.location.href = '<?= $link->url('order.index') ?>';
            } else {
                console.error('Error saving order items');
            }
        };

        xhr.send(JSON.stringify({orderId: orderId, productItems: orderItems}));
    }

</script>
