<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function all();
    public function create(array $data, array $details);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);

}
