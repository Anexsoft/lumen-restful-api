<?php

namespace App\DTOs\Orders;

use Spatie\DataTransferObject\DataTransferObject;

class OrderCreateDto extends DataTransferObject
{
    public int $customer_id;
    public array $items;
}