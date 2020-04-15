<?php
namespace App\Repositories;

use Exception;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use App\DTOs\Orders\OrderCreateDto;
use Illuminate\Pagination\Paginator;
use App\Repositories\Interfaces\IOrderRepository;

class OrderRepository implements IOrderRepository
{
    public function paginate(int $take): Paginator
    {
        $result = Order::simplePaginate($take);

        $result->load('items', 'customer');

        return $result;
    }

    public function find(int $id): ?Order
    {
        $entry = Order::find($id);

        if($entry) 
        {
            $entry->load('items', 'customer');
        }

        return $entry;
    }

    public function store(OrderCreateDto $store): Order
    {
        $entry = new Order();
        $entry->customer_id = $store->customer_id;

        // total
        $this->setTotal($entry, $store->items);

        // item
        $this->setItem($store);

        // save
        DB::transaction(function () use($entry, $store) {
            $entry->save();

            $entry->items()
                  ->saveMany($store->items);
        });

        return $entry;
    }

    private function setTotal(Order &$order, array &$items): void
    {
        foreach($items as $k => $item) 
        {
            // total header
            $order->total += $item['quantity'] * $item['unit_price'];
        }
    }

    private function setItem(OrderCreateDto &$store) 
    {
        $detail = [];

        foreach($store->items as $item) 
        {
            $order_detail = new OrderDetail;

            $order_detail->quantity = $item['quantity'];
            $order_detail->product_id = $item['product_id'];
            $order_detail->unit_price = $item['unit_price'];
            $order_detail->total = $item['unit_price'] * $item['quantity'];

            $detail[] = $order_detail;
        }

        $store->items = $detail;
    }
}
