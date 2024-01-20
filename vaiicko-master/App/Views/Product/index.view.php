<?php
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */


?>
<div class="content-container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $data['product']->getImage() ?>" alt="<?=$data['product']->getName()?>" style="width:100%;">
            </div>
            <div class="col-md-6">

                <h2><?= $data['product']->getName(); ?></h2>

                <p><?= $data['product']->getDescription(); ?></p>
                <h3 class="me-3">Cena: <?= $data['product']->getPrice(); ?>€</h3>
                <div class="input-group">
                    <button class="btn btn-outline-secondary minus-button" type="button" onclick="decrementQuantity()">-</button>
                    <input type="text" class="form-control quantity-input" id="quantity" placeholder="1" aria-label="Quantity" style="max-width: 35px;">
                    <button class="btn btn-outline-secondary plus-button" type="button" onclick="incrementQuantity()">+</button>

                    <form action="<?= $link->url('shoppingCart.save') ?>" method="post" onsubmit="return validateForm()">
                        <input type="hidden" name="product_id" id="product_id" value="<?= $data['product']->getId(); ?>">
                        <input type="hidden" name="quantity" id="hiddenQuantity" value="1"> <!-- Alebo iná hodnota množstva -->
                        <button class="btn btn-primary mybtn" type="submit">Pridať do košíka <i class="bi bi-basket-fill"></i></button>
                    </form>
                </div>
            </div>
            <div class="separator">
                <hr>
                <span>Starostlivosť</span>
                <hr>
            </div>
            <div>
                <p><?= $data['product']->getCare(); ?></p>
            </div>
        </div>
</div>

<script src="../../../public/js/quantity.js"></script>