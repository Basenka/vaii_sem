<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Product|null $productToEdit */
/** @var Array $data */

use App\Models\Product;

//skontroluje ci sa hodnota nachadza v Get a zmeni ju na int
$productIdToEdit = isset($_GET['id']) ? intval($_GET['id']) : null;
$productToEdit = null;

if ($productIdToEdit !== null) {
    $productToEdit = Product::getOne($productIdToEdit);
}
?>

<form id="productForm" class="my-form registration-form" enctype="multipart/form-data" action="<?= $link->url('product.save') ?>" method="post">

    <input type="hidden" name="id" value="<?= @$data['product']?->getId() ?>">
    <?php if ($productToEdit && @$data['product']?->getImage() != ""): ?>
        <div>Pôvodný súbor: <?= substr($data['product']->getImage(), strpos($data['product']->getImage(), '-') + 1)  ?></div>
    <?php endif; ?>
    <div class="form-group">
        <label for="name">Názov produktu:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= $productToEdit ? $productToEdit->getName() : '' ?>" required>
        <span id="nameError" class="error"></span>
    </div>

    <div class="form-group">
        <label for="picture">Obrázok produktu:</label>
        <input type="file" id="picture" name="picture" accept="image/*" class="form-control">
        <!-- @ znamena potlacenie chyb, nevrati klasicky chybu ale null-->
        <?php if ($productToEdit && @$data['product']?->getImage() != ""): ?>
            <p>Pre zmenu obrázka vyberte nový súbor. Ponechajte prázdne, ak nechcete meniť obrázok.</p>
        <?php endif; ?>
        <span id="imageError" class="error"></span>
    </div>

    <div class="form-group">
        <label for="description">Popis produktu:</label>
        <textarea id="description" name="description" class="form-control" required><?= $productToEdit ? $productToEdit->getDescription() : '' ?></textarea>
        <span id="descriptionError" class="error"></span>
    </div>

    <div class="form-group">
        <label for="care">Starostlivosť o produkt:</label>
        <textarea id="care" name="care" class="form-control" required><?= $productToEdit ? $productToEdit->getCare() : '' ?></textarea>
        <span id="careError" class="error"></span>
    </div>

    <div class="form-group">
        <label for="price">Cena produktu:</label>
        <input type="number" id="price" name="price" class="form-control" value="<?= $productToEdit ? $productToEdit->getPrice() : '' ?>" required>
        <span id="priceError" class="error"></span>
    </div>

    <input type="submit" value="<?= $productToEdit ? 'Upraviť rastlinu' : 'Pridať rastlinu' ?>" class="btn mybtn btn-primary">
</form>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="../../../public/js/productValidation.js"></script>

