<?php

namespace App\Integrations;


class SourceProducts
{

  private $client;


  public function __construct()
  {
    $this->client = new Client(env('MICROSERVICE_PRODUCT_INTEGRATION_URL',''));
  }

  public function get($productId, $paymentMethodId, $conditionId)
  {
    $response = $this->client->get('products', [
      'query' => [
        'product_id' => $productId,
        'payment_method_id' => $paymentMethodId,
        'condition_id' => $conditionId
      ]
    ]);

    $product = json_decode($response->getBody()->getContents(), true);

    return $product;
  }

}