<?php

namespace Tests\Feature\Controller;


use Tests\TestCase;


class CartControllerTest extends TestCase
{

  public function setUp(): void
  {
    parent::setUp();
  }


  public function testAddItem()
  {
    $item = 5104;
    $data = json_decode('{
      "item":{
        "weight":100,
        "name":"item1",
        "price":100,
        "quantity":1
     },
      "customer":{
         "clientId": "1234",
         "info": {}
      }
    }', true);

    $response = $this->post('/api/cart/add/' . $item, $data);
    $response->assertStatus(200);
  }
}
