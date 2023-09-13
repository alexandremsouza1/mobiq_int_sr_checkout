<?php

namespace Tests\Unit\Services;

use App\Dto\CartItemDto;
use App\Dto\CustomerDto;
use App\Factory\FactoryCart;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Repositories\CartRepository;
use App\Services\CartService;
use Mockery;
use Tests\TestCase;


class CartServiceTest extends TestCase
{

  private $service;

  public function setUp(): void
  {
    parent::setUp();
    $this->service = $this->mockService();
  }

  private function mockService()
  {
    $mock = new CartService($this->mockRepository(), $this->mockFactoryCart());
    return $mock;
  }

  public function mockRepository()
  {
    $cartModel = new Cart();
    $mock = new CartRepository($cartModel);
    return $mock;
  }

  public function mockFactoryCart()
  {
    $mock = new FactoryCart($this->mockCustomerDto(), $this->mockCartItemDto(), $this->mockSourceProducts());
    return $mock;
  }

  public function mockCustomerDto()
  {
    $customerModel = new Customer();
    $mock = new CustomerDto($customerModel);
    return $mock;
  }

  public function mockCartItemDto()
  {
    $mock = new CartItemDto($this->mockCartItem());
    return $mock;
  }

  public function mockCartItem()
  {
    $mock = new CartItem();
    return $mock;
  }

  public function mockSourceProducts()
  {
    $mock = Mockery::mock('App\Integrations\SourceProducts');
    $mock->shouldReceive('get')->andReturn([
      "suggestedQuantity" => 0,
      "action" => false,
      "charge" => 0.00,
      "code" => 52792,
      "weight" => 100,
      "unitFactor" => 0.369800,
      "productName" => "product1",
      "kit" => false,
      "material" => "000000000100001523",
      "polarized" => false,
      "unitPrice" => 100,
      "priceTable" => "9000000070_2308300012",
      "orderType" => "ZS23",
      "segment" => "",
      "brand" => "00033",
      "category" => "",
      "packagingType" => "2",
      "groupKonnect" => "00001",
      "deliveryType" => "",
      "flavor" => ""
    ]);
    return $mock;
  }


  public function testAddItemWithCartNonExistent()
  {
    $data = json_decode('{
      "item":{
        "product":52792,
        "weight":100,
        "name":"item1",
        "price":100,
        "quantity":1
     },
      "customer":{
         "clientId": "1234",
         "info": {}
      },
      "payment":{
          "paymentMethod": "credit",
          "paymentCondition": "XX06"
      }
    }', true);

    $response = $this->service->addItem($data['customer'], $data['payment'], $data['item']);
    $this->assertIsArray($response);
  }
}
