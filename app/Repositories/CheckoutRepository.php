<?php

namespace App\Repositories;

use App\Models\Checkout;

class CheckoutRepository extends AbstractRepository
{

    public function __construct(Checkout $model)
    {
        $this->model = $model;
    }
}
