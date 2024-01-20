<?php
$layout = 'admin';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="content">
    <h2>Objednávky</h2>
    <button class="btn mybtn" onclick="toggleFilterOptions()">Filter</button>
    <div class="form-group" id="filterOptions" style="display: none;">
        <label for="filter">Filter:</label>
        <input class="form-control" type="text" id="filter" name="filter">

        <label for="filterColumn">Filtrovaný stĺpec:</label>
        <select class="form-control" id="filterColumn" name="filterColumn">
            <option value="user_id">ID používateľa</option>
            <option value="date">Dátum</option>
            <option value="totalPrice">Celková cena</option>
            <option value="status">Stav objednávky</option>
        </select>

        <button class="btn mybtn" onclick="applyFilter()">Filtrovať</button>
        <button class="btn mybtn" onclick="clearFilter()">Zrušiť filter</button>
    </div>
    <table id="orderTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>ID používateľa</th>
            <th>Dátum</th>
            <th>Celková cena</th>
            <th>Stav objednávky</th>
            <th>Vymazať</th>
        </tr>
        </thead>
        <tbody>
        <?php $orders = $data['orders'];
        foreach ($orders as $order): ?>
            <tr onclick="window.location='<?= $link->url('admin.orderDetails', ['id' => $order->getId()]) ?>';" style="cursor:pointer;">
                <td><?= $order->getId() ?></td>
                <td><?= $order->getUserId() ?></td>
                <td><?= $order->getDate() ?></td>
                <td><?= $order->getTotalPrice() ?></td>
                <td><?= $order->getStatus() ?></td>
                <td><a href="<?= $link->url('order.delete', ['id' => $order->getId()]) ?>"
                       class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var config = {
        filteredItemsUrl: '<?= $link->url('order.filtered') ?>',
        allItemsUrl: '<?= $link->url('order.all') ?>'
    };
</script>

<script src="../../../public/js/filter.js"></script>
<script>
    function updateTable(orders) {
        var tableBody = $('#orderTable tbody');
        tableBody.empty();

        for (var i = 0; i < orders.length; i++) {
            var order = orders[i];
            var url = '<?= $link->url('admin.orderDetails', ['id' => '']) ?>/' + order.id;
            var row = '<tr onclick="window.location=\'' + url + '\';" style="cursor:pointer;">' +
                '<td>' + order.id + '</td>' +
                '<td>' + order.user_id + '</td>' +
                '<td>' + order.date + '</td>' +
                '<td>' + order.total_price + '</td>' +
                '<td>' + order.status + '</td>' +
                '<td><a href="<?= $link->url('order.delete', ['id' => '']) ?>/' + order.id +
                '" class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>' +
                '</tr>';

            tableBody.append(row);
        }
    }
</script>


