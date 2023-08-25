<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderService
{

    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function handleGetOrders()
    {
        $orders = $this->orderRepository->all();
        return $orders->map(function ($order) {
            return $this->formatOrderData($order);
        });
    }

    public function handleCreateOrder(array $data)
    {
        $details = $data['details'] ?? [];
        unset($data['details']);
        $order =  $this->orderRepository->create($data, $details);
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    public function handleGetOrder($id)
    {
        $order =  $this->orderRepository->show($id);
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    public function handleUpdateOrder($id, array $data)
    {
        return $this->orderRepository->update($id, $data);
    }

    public function handleDestroyOrder($id)
    {
        return $this->orderRepository->delete($id);
    }

    protected function formatOrderData($order)
    {
        return [
            'id' => $order->id,
            'client_name' => $order->client_name,
            'status' => $order->status,
            'details' => $this->formatDetails($order->orderDetails),
        ];
    }

    protected function formatDetails($details)
    {
        return $details->map(function ($detail) {
            return [
                'id' => $detail->id,
                'quantity' => $detail->quantity,
                'recipe' => $detail->recipe,
                'comments' => $detail->comments,
            ];
        });
    }
}