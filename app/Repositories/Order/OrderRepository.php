<?php

namespace App\Repositories\Order;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{

    public function all()
    {
        return Order::with('orderDetails.recipe:id,name')->get();
    }

    public function create(array $data, array $details)
    {
        $order = Order::create($data);
        $order->orderDetails()->createMany($details);
        return $order;
    }

    public function show($id)
    {
        $order = Order::with('orderDetails.recipe:id,name')->find($id);
        if (!$order) {
            throw new CustomException('Order not found.', 404);
        }
        return $order;
    }

    public function update($id, array $data)
    {
        $order = Order::find($id);
        if (!$order) {
            throw new CustomException('Order not found.', 404);
        }
        $order->update(['status' => $data['status']]);
        return $order;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if (!$order) {
            throw new CustomException('Order not found.', 404);
        }
        $order->delete();
    }
}