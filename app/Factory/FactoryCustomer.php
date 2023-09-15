<?php

namespace App\Factory;

use App\Repositories\CustomerRepository;

class FactoryCustomer implements FactoryInterface {


  
  private $customer;

  public function __construct(CustomerRepository $customer)
  {
    $this->customer = $customer;
  }


  public function convertData(array $data)
  {
    $find = $this->customer->findByKey('clientId', $data['clientId']);
    if($find) {
      return $find;
    }
    return $this->customer->store($data);
  }

}