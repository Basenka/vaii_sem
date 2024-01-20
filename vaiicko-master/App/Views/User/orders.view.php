<?php
$layout = 'profile';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="content">
    <h2>Objednávky</h2>
    <div class="table-responsive">
        <table id="orderTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Dátum</th>
                <th>Celková cena</th>
                <th>Stav objednávky</th>
            </tr>
            </thead>
            <tbody>
            <?php $orders = $data['orders'];
            foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order->getId() ?></td>
                    <td><?= $order->getDate() ?></td>
                    <td><?= $order->getTotalPrice() ?></td>
                    <td><?= $order->getStatus() ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>




