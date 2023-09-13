<?php

namespace App\Factory;

use App\Dto\CartItemDto;
use App\Dto\CustomerDto;
use App\Integrations\SourceProducts;
use App\Models\Cart;

class FactoryCart {


  private $customer;

  private $cartItem;

  private $sourceProducts;

  public function __construct(CustomerDto $customer, CartItemDto $cartItem,SourceProducts $sourceProducts)
  {
    $this->customer = $customer;
    $this->cartItem = $cartItem;
    $this->sourceProducts = $sourceProducts;
  }

  public function createCustomer(Cart $cart, array $params)
  {
    $customer = $this->customer->create($cart, $params);
    return $customer;
  }

  public function createItem(Cart $cart, array $payment, string $codeProduct)
  {
    $product = $this->sourceProducts->get($codeProduct, $payment['paymentMethod'], $payment['paymentCondition']);
    $cartItem = $this->cartItem->create($cart, [
      'quantity' => 1,
      'price' => 0,
      'weight' => 0,
      'label' => 'Produto teste',
    ], $product);
    return $cartItem;
  }
}