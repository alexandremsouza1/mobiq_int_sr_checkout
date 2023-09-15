<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository extends AbstractRepository
{

    public function __construct(CartItem $model)
    {
        $this->model = $model;
    }
}
