<?php

/** @var Array $data */
/** @var \App\Models\Plant $plant */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="separator">
    <hr>
    <span>Novinky</span>
    <hr>
</div>
<div class="separator">
    <hr>
    <span>Najobľúbenejšie produkty</span>
    <hr>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <?php foreach ($data['plants'] as $plant): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $plant->getImage() ?>" class="card-img-top img-fluid" alt="<?= $plant->getName() ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $plant->getName() ?></h5>
                        <p class="card-text">Price: $<?= $plant->getPrice() ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?= $link->url('post.edit', ['id' => $plant->getId()]) ?>" class="btn btn-primary">Edit</a>
                        <button class="btn btn-success" onclick="addToCart(<?= $plant->getId() ?>, '<?= $plant->getName() ?>', <?= $plant->getPrice() ?>)">Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

