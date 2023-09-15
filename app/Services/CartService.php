<?php

namespace App\Services;

use App\Enums\CartStatus;
use App\Factory\FactoryCart;
use App\Integrations\SourceProducts;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;

class CartService extends AbstractService
{

  private $repository;

  private $factoryCart;

  private $sourceProducts;

  private $productRepository;


  public function __construct(
    FactoryCart $factoryCart, 
    SourceProducts $sourceProducts,
    CartRepository $repository,
    ProductRepository $productRepository,
    )
  {
      $this->repository = $repository;
      $this->factoryCart = $factoryCart;
      $this->sourceProducts = $sourceProducts;
      $this->productRepository = $productRepository;
  }


  public function getCart($ustomer)
  {
    $cart = $this->repository->findByKey('clientId', $ustomer->clientId,'created_at','desc');
    return $cart;
  }

  public function addItem($data)
  {
    $resultSourceProducts = null;
    list($customer, $item, $payment) = $this->factoryCart->convertData($data);

    $resultSourceProducts = $this->sourceProducts->get($item->product, $payment->paymentMethod, $payment->paymentCondition);

    $this->startTranscation();
    try {
      $product = $this->findOrCreateProduct($resultSourceProducts);
      $cart = $this->findOrCreateCart($customer, $payment);
      $this->updateCartItem($cart, $item, $product);
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

  private function updateCartItem(Cart $cart, CartItem $item, Product $product)
  {
      $cartItem = $cart->items()->where('productId', $product->id)->first();

      if ($cartItem) {
          $cartItem->increment('quantity', $item->quantity);
      } else {
          $item->cart()->associate($cart);
          $cart->items()->save($item);
          $item->product()->associate($product);
          $item->save();
      }
  }

  private function findOrCreateCart(Customer $customer, Payment $payment = null): Cart
  {
    $status_open = CartStatus::Open;
    $cart = $this->repository->findByCriteria(['customerId' => $customer->id, 'status' => $status_open]);
    if (!$cart) {
      $cart = $this->repository->save([
        'customerId' => $customer->id,
        'status' => $status_open
      ]);
    }
    if($payment) {
      $payment->cart()->associate($cart);
      $cart->payment()->save($payment);
    }
    return $cart;
  }

  private function findOrCreateProduct(array $data)
  {
    return $this->productRepository->store($data, 'code');
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