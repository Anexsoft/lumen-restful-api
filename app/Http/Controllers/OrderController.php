<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DTOs\Orders\OrderCreateDto;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IOrderRepository;

class OrderController extends Controller
{
    private IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        return $this->orderRepository->paginate(20);
    }

    public function show(int $id)
    {
        $result = $this->orderRepository->find($id);

        if($result) {
            return $result;
        }

        return response('Order not found', 404);
    }

    public function items(int $id)
    {
        $result = $this->orderRepository->find($id);

        if($result) {
            return $result->items()->paginate(1);
        }

        return response('Order not found', 404);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_price' => 'required|numeric|min:1'
        ]);

        $store = new OrderCreateDto($request->all());

        $result = $this->orderRepository->store($store);

        return response($result, 201);
    }
}
