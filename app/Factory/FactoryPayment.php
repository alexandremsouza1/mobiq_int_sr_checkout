<?php

namespace App\Factory;

use App\Repositories\PaymentRepository;

class FactoryPayment implements FactoryInterface {


  
  private $payment;

  public function __construct(PaymentRepository $payment)
  {
    $this->payment = $payment;
  }


  public function convertData(array $data)
  {
    $model = $this->payment->getModel();
    return $model->fill($data);
  }

}