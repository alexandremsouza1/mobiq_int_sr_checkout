<?php


namespace App\Dto;

use App\Models\Cart;


class CustomerDto
{

  public function create(Cart $cart,array $params)
  {
    $params['cartId'] = $cart->id;
    $customer = $cart->customer()->create($params);
    return $customer;
  }
}