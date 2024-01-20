<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected ?int $id = null;
    protected ?string $name;
    protected ?string $image;
    protected ?string $description;
    protected ?float $price;
    protected ?string $care;
    protected ?string $added_at;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getCare(): ?string
    {
        return $this->care;
    }

    public function setCare(string $care): void
    {
        $this->care = $care;
    }

    public function getAddedAt(): ?string
    {
        return $this->added_at;
    }

    public function setAddedAt(?string $addedAt): void
    {
        $this->added_at = $addedAt;
    }


}
