<?php
namespace App\Repositories\Interfaces;

use App\Models\Order;
use App\DTOs\Orders\OrderCreateDto;
use Illuminate\Pagination\Paginator;

interface IOrderRepository
{
    public function paginate(int $take): Paginator;
    public function find(int $id): ?Order;
    public function store(OrderCreateDto $store): Order;
}
