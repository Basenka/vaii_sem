<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected ?int $id = null;
    protected ?int $user_id;
    protected ?int $plant_id;
    protected ?int $quantity;
    protected ?string $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getPlantId(): ?int
    {
        return $this->plant_id;
    }

    public function setPlantId(int $plant_id): void
    {
        $this->plant_id = $plant_id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }
}
