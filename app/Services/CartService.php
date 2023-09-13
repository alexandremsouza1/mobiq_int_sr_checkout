<?php

namespace App\Services;

use App\Enums\CartStatus;
use App\Factory\FactoryCart;
use App\Models\Cart;
use App\Models\Customer;
use App\Repositories\CartRepository;

class CartService extends AbstractService
{

  protected $repository;

  protected $factoryCart;


  public function __construct(CartRepository $repository,FactoryCart $factoryCart)
  {
      $this->repository = $repository;
      $this->factoryCart = $factoryCart;
  }

  public function getCart($ustomer)
  {
    $cart = $this->repository->findByKey('clientId', $ustomer->clientId,'created_at','desc');
    return $cart;
  }

  public function addItem($customer, $payment, $item)
  {
    $this->startTranscation();
    try {
      $cart = $this->findOrCreateCart($customer['clientId']);
      $item = $this->factoryCart->createItem($cart,$payment,$item['product']);
      $customer = $this->factoryCart->createCustomer($cart, $customer);
      $this->commitTranscation();
      return [
        'cart' => $cart,
        'items' => $cart->items,
        'customer' => $cart->customer
      ];
    } catch (\Exception $e) {
      $this->rollbackTranscation();
      throw $e;
    }
  }

  private function findOrCreateCart(string $clientId) : Cart
  {
    $status_open = CartStatus::Open;
    $cart = $this->repository->findByCriteria(['clientId' => $clientId,'status' => $status_open]);
      if(!$cart) {
        $cart = $this->repository->store([
          'clientId' => $clientId,
          'status' => $status_open
        ]);
      }
    return $cart;
  }

  public function updateCart($params)
  {
    $clientId = $params['clientId'];
    $cart = $this->repository->findByKey('clientId',$clientId,'created_at','desc');
    if($cart) {
      $cart->fill($params);
      if($cart->validate($params)) {
        $cart->save();
        return $cart;
      }
    }
    return false;
  }

  public function updateItem($user, $item, $attribute, $value)
  {
    $cart = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    if($cart) {
      $cart->items()->updateExistingPivot($item, [$attribute => $value]);
      return $cart;
    }
    return false;
  }

  public function updateShipping($user, $shipping)
  {
    $cart = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    if($cart) {
      $cart->shipping_id = $shipping;
      $cart->save();
      return $cart;
    }
    return false;
  }

  public function removeItem($user, $item)
  {
    $cart = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    if($cart) {
      $cart->items()->detach($item);
      return $cart;
    }
    return false;
  }


}