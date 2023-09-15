<?php

namespace Tests\Unit\Services;


use App\Factory\FactoryCart;
use App\Factory\FactoryCartItem;
use App\Factory\FactoryCustomer;
use App\Factory\FactoryPayment;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
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
    $mock = new CartService($this->mockFactoryCart(), $this->mockSourceProducts(), $this->mockCartRepository(), $this->mockProductsRepository());
    return $mock;
  }

  public function mockCartRepository()
  {
    $cartModel = new Cart();
    $mock = new CartRepository($cartModel);
    return $mock;
  }

  public function mockProductsRepository()
  {
    $cartModel = new Product();
    $mock = new ProductRepository($cartModel);
    return $mock;
  }

  public function mockFactoryCart()
  {
    $mock = new FactoryCart($this->mockCustomer(), $this->mockCartItem(), $this->mockPayment());
    return $mock;
  }

  public function mockCustomer()
  {
    $customerRepository = new CustomerRepository(new Customer());
    $mock = new FactoryCustomer($customerRepository);
    return $mock;
  }


  public function mockCartItem()
  {
    $cartItemRepository  = new CartItemRepository(new CartItem());
    $mock = new FactoryCartItem($cartItemRepository);
    return $mock;
  }

  public function mockPayment()
  {
    $paymentRepository  = new PaymentRepository(new Payment()); 
    $mock = new FactoryPayment($paymentRepository);
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
        "label":"item1",
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

    $response = $this->service->addItem($data);
    $this->assertIsArray($response);
  }
}
