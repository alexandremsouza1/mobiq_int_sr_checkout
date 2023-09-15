<?php

namespace App\Factory;

use App\Repositories\CartItemRepository;

class FactoryCartItem implements FactoryInterface {


  private $cartItem;

  public function __construct(CartItemRepository $cartItem)
  {
    $this->cartItem = $cartItem;
  }


  public function convertData(array $data)
  {
    $model = $this->cartItem->getModel();
    //$data['productId'] = isset($data['product']) && !empty($data['product']) ? $data['product'] : '';
    return $model->fill($data);
  }

}