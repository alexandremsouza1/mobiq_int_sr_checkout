<?php

namespace App\Services;

use App\Repositories\CheckoutRepository;

class CheckoutService extends AbstractService
{

  protected $repository;


  public function __construct(CheckoutRepository $repository,)
  {
      $this->repository = $repository;
  }

  public function getCheckout($user)
  {
    $checkout = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    return $checkout;
  }

  public function updatePaymentMethod($user, $id, $condition)
  {
    $checkout = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    $checkout->payment_method = $condition;
    $checkout->save();
    return $checkout;
  }

  public function checkout($user)
  {
    $checkout = $this->repository->findByKey('user_id', $user->id,'created_at','desc');
    $checkout->status = 'paid';
    $checkout->save();
    return $checkout;
  }

}