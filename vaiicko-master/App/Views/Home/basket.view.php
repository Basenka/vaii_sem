<?php

/** @var Array $data */
/** @var \App\Models\Post $post */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="main-container">
                <h2>Košík</h2>

                <!-- Cart Items -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">

                                <img src="path/to/image.jpg" alt="Item Image" class="me-3" style="max-width: 100px;">

                                <div>
                                    <h5 class="card-title">Izbová Rastlina 1</h5>
                                </div>
                                <div>
                                    <p class="card-text">$20.00</p>
                                </div>

                                <div class="input-group">
                                    <button class="btn btn-outline-secondary minus-button" type="button">-</button>
                                    <input type="text" class="form-control quantity-input" placeholder="1" aria-label="Quantity" style="max-width: 35px; ">
                                    <button class="btn btn-outline-secondary plus-button" type="button">+</button>
                                </div>

                                <button class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Price -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h4>Celková cena: $20.00</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="<?= $link->url("home.index") ?>" class="btn btn-primary">Pokračovať v nákupe</a>
                        <a href="#" class="btn btn-success">Pokračovať na pokladňu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
