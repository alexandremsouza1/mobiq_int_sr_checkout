<?php

namespace App\Factory;

use App\Integrations\SourceProducts;
use App\Models\Cart;

class FactoryCart implements FactoryInterface {


  protected $factoryCustomer;

  protected $factoryCartItem;

  protected $factoryPayment;

  public function __construct(FactoryCustomer $factoryCustomer, FactoryCartItem $factoryCartItem, FactoryPayment $factoryPayment)
  {
    $this->factoryCustomer = $factoryCustomer;
    $this->factoryCartItem = $factoryCartItem;
    $this->factoryPayment = $factoryPayment;
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



  public function convertData(array $data)
  {
    $customer = $this->factoryCustomer->convertData($data['customer']);
    $item = $this->factoryCartItem->convertData($data['item']);
    $payment = $this->factoryPayment->convertData($data['payment']);
    return [$customer, $item, $payment];
  }
}