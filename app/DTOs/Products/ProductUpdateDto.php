<?php

namespace App\DTOs\Products;

use Spatie\DataTransferObject\DataTransferObject;

class ProductUpdateDto extends DataTransferObject
{
    public int $id;
    public string $sku;
    public string $name;
    public string $description;
    public float $price;
}
