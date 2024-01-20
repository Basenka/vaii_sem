<?php
$layout = 'admin';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="content">
    <h2>Produkty</h2>
    <a href="<?= $link->url('admin.addProduct') ?>" class="btn mybtn">Pridať produkt</a>
    <button class="btn mybtn" onclick="toggleFilterOptions()">Filter</button>
    <div class="form-group" id="filterOptions" style="display: none;">
        <label for="filter">Filter:</label>
        <input class="form-control" type="text" id="filter" name="filter">

        <label for="filterColumn">Filtrovaný stĺpec:</label>
        <select class="form-control" id="filterColumn" name="filterColumn">
            <option value="name">Názov</option>
            <option value="Price">Cena</option>
        </select>

        <button class="btn mybtn" onclick="applyFilter()">Filtrovať</button>
        <button class="btn mybtn" onclick="clearFilter()">Zrušiť filter</button>
    </div>
    <div class="table-responsive">
        <table id="productTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Cena</th>
                <th>Vymazať</th>

            </tr>
            </thead>
            <tbody>
            <?php $products = $data['products'];
            foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->getId() ?></td>
                    <td><?= $product->getName() ?></td>
                    <td><?= $product->getPrice() ?></td>
                    <td><a href="<?= $link->url('product.delete', ['id' => $product->getId()]) ?>"
                           class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var config = {
        filteredItemsUrl: '<?= $link->url('product.filtered') ?>',
        allItemsUrl: '<?= $link->url('product.all') ?>'
    };
</script>

<script src="../../../public/js/filter.js"></script>
<script>
    function updateTable(products) {
        var tableBody = $('#productTable tbody');
        tableBody.empty();

        for (var i = 0; i < products.length; i++) {
            var product = products[i];
            var row = '<tr>' +
                '<td>' + product.id + '</td>' +
                '<td>' + product.name + '</td>' +
                '<td>' + product.price + '</td>' +
                '<td><a href="<?= $link->url('product.delete', ['id' => '']) ?>/' + product.id +
                '" class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>' +
                '</tr>';

            tableBody.append(row);
        }
    }
</script>
