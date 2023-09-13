<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository extends AbstractRepository
{

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }
}
