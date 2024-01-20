<?php
$layout = 'admin';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
$order = $data['order'];
$orderId = $data['orderId'];
$userId = $order->getUserId();
$orderItems = [];

foreach ($data['orderItems'] as $item) {
    if ($item->getOrderId() == $orderId) {
        $orderItems[] = [
            'id' => $item->getProductId(),
            'price' => $item->getUnitPrice(),
            'quantity' => $item->getQuantity(),
        ];
    }
}

$orderStatusOptions = ['new', 'Processing', 'Shipped', 'Delivered'];
$currentOrderStatus = $order->getStatus();
?>
<div class="content">
    <h2>Detaily objednávky</h2>
    <p>ID objednávky: <?= $orderId ?></p>
    <p>ID používateľa: <?= $userId ?></p>

    <h3>Položky objednávky</h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Množstvo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="<?= $link->url('order.edit') ?>" method="post">
            <label for="orderStatus">Stav objednávky:</label>
            <select class="form-control" name="orderStatus" id="orderStatus">
                <?php foreach ($orderStatusOptions as $status): ?>
                    <option value="<?= $status ?>" <?= ($status === $currentOrderStatus) ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="id" value="<?= $orderId ?>">
            <button class="btn mybtn" type="submit">Zmeniť stav</button>
        </form>

    </div>
</div>
