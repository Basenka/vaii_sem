<?php

namespace App\Models;

use App\Core\Model;

class OrderItem extends Model {

    protected ?int $id = null;
    protected ?int $order_id;
    protected ?int $product_id;
    protected ?int $quantity;
    protected ?float $unit_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOrderId(): ?int
    {
        return $this->order_id;
    }

    public function setOrderId(?int $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(?int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(?float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }


}
