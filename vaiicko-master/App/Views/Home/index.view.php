
<?php

/** @var Array $data */
/** @var \App\Models\Product $product */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>


<div class="separator">
    <hr>
    <span>Novinky</span>
    <hr>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <?php
        $newProducts = array_filter($data['products'], function($product) {
            // Filtrovať produkty pridané pred menej ako jedným dňom
            return strtotime($product->getAddedAt()) > strtotime('-1 day');
        });

        foreach ($newProducts as $product):
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <a href="<?= $link->url('product.index', ['id' => $product->getId()]) ?>" class="card-link custom-link">
                        <div class="card">
                            <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $product->getImage() ?>" class="card-img-top img-fluid" alt="<?= $product->getName() ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product->getName() ?></h5>
                                <p class="card-text">Cena: <?= $product->getPrice() ?>€</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php if ($auth->isLogged()) {
                                    $user = $auth->getLoggedUserContext();
                                    if ($user->getRole() == 'employee' or $user->getRole() == 'admin') { ?>
                                        <div class="d-flex">
                                            <a href="<?= $link->url('product.edit', ['id' => $product->getId()]) ?>" class="btn mybtn me-2">
                                                <span class="d-none d-xl-inline">Upraviť</span>
                                                <span class="d-inline d-xl-none"><i class="bi bi-pencil-square"></i></span>
                                            </a>
                                            <a href="<?= $link->url('product.delete', ['id' => $product->getId()]) ?>" class="btn btn-danger">
                                                <span class="d-none d-xl-inline">Vymazať</span>
                                                <span class="d-inline d-xl-none"><i class="bi bi-trash-fill"></i></span>
                                            </a>
                                        </div>
                                    <?php }
                                } ?>
                                <form action="<?= $link->url('shoppingCart.save') ?>" method="post" class="ms-auto">
                                    <input type="hidden" name="product_id" id="product_id" value="<?= $product->getId(); ?>">
                                    <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
                                    <button class="btn mybtn btn-sm" type="submit"><i class="bi bi-basket-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="separator">
    <hr>
    <span>Najobľúbenejšie produkty</span>
    <hr>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <?php foreach ($data['products'] as $product): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="<?= $link->url('product.index', ['id' => $product->getId()]) ?>" class="card-link custom-link">
                    <div class="card">
                        <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $product->getImage() ?>" class="card-img-top img-fluid" alt="<?= $product->getName() ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product->getName() ?></h5>
                            <p class="card-text">Cena: <?= $product->getPrice() ?>€</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <?php if ($auth->isLogged()) {
                                $user = $auth->getLoggedUserContext();
                                if ($user->getRole() == 'employee' or $user->getRole() == 'admin') { ?>
                                    <div class="d-flex">
                                        <a href="<?= $link->url('product.edit', ['id' => $product->getId()]) ?>" class="btn mybtn me-2">
                                            <span class="d-none d-xl-inline">Upraviť</span>
                                            <span class="d-inline d-xl-none"><i class="bi bi-pencil-square"></i></span>
                                        </a>
                                        <a href="<?= $link->url('product.delete', ['id' => $product->getId()]) ?>" class="btn btn-danger">
                                            <span class="d-none d-xl-inline">Vymazať</span>
                                            <span class="d-inline d-xl-none"><i class="bi bi-trash-fill"></i></span>
                                        </a>
                                    </div>
                                <?php }
                            } ?>
                            <form action="<?= $link->url('shoppingCart.save') ?>" method="post" class="ms-auto">
                                <input type="hidden" name="product_id" id="product_id" value="<?= $product->getId(); ?>">
                                <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
                                <button class="btn mybtn btn-sm" type="submit"><i class="bi bi-basket-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

