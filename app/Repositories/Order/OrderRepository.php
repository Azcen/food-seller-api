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
        return Order::with('orderDetails.recipe:id,name')->find($id);
    }

    public function update($id, array $data)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $data['status']]);
        return $order;
    }

    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
    }
}