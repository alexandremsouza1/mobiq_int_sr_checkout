<?php


namespace App\Dto;

use App\Models\Cart;
use App\Models\Product;

class CartItemDto
{


  public function create(Cart $cart,array $params,array $data_product)
  {
    $product = new Product($data_product);
    $product->save();
    $cartItem = $cart->items()->create($params);
    $cartItem->product()->associate($product);
    $cartItem->save();
    return $cartItem;
  }

}