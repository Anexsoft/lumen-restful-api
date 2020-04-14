<?php

namespace App\DTOs\Products;

use Spatie\DataTransferObject\DataTransferObject;

class ProductCreateDto extends DataTransferObject
{
    public string $sku;
    public string $name;
    public string $description;
    public float $price;
}
