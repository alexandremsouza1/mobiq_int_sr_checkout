<?php

namespace Tests\Feature\Controller;


use Tests\TestCase;


class CheckoutControllerTest extends TestCase
{

  public function setUp(): void
  {
    parent::setUp();
  }


  public function testCheckout()
  {
    $data = json_decode('{
      "items":[
         {
            "code":"5104",
            "weight":100,
            "name":"item1",
            "price":100,
            "quantity":1
         },
         {
            "code":"52792",
            "weight":200,
            "name":"item2",
            "price":200,
            "quantity":2
         }
      ],
      "customer":{
         "code":"1234",
         "info":{
            
         }
      },
      "delivery":{
         "type":"conventional",
         "scheduledDelivery":"2017-01-01T00:00:00Z",
         "amount":1000
      },
      "payment":{
         "type":"credit",
         "amount":1000,
         "cart":{
            "ct":"oenOxuAxNvxLJagINDPEPtEq/s/A8f8scl3kppvUPNSmb2+EkyEk/1cmkOnOnAB2L9rNoCJF4tPBRphuC/dXXriL2mnB0mknRV+sfFmkvzbkQFXBMSj+dbTGGz9t0SreXccCyYgWeu0MmJL11HZIQFamtudwJcTKCNjej33Nm0fXCdEV9/94J17Jnse2X346kELSgrcmXTMl2iYcOliGSFxpA8c3izzcElNSpyJQLglbwDR/O8rGqYvqnOCmGUptjVj4LQJkCwKCKB3u5cniHuyntUrjyBcoWCWgOgnHxoiNtvtCrM4gM7raF4TzQR3cEWtSZ1rouGSuKpsbN/uYlQ==",
            "iv":"9b442312f3705e46bc32dbaf6ccc8e99",
            "s":"e0b05d27f0b4c503"
         }
      }
    }', true);

    $response = $this->post('/api/checkout', $data);
    $response->assertStatus(200);
  }

}
