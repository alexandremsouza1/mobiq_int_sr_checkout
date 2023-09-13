<?php

namespace App\Integrations;


class SourceCustomer
{

  private $client;


  public function __construct()
  {
    $this->client = new Client(env('MICROSERVICE_CUSTOMER_INTEGRATION_URL',''));
  }

}