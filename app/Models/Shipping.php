<?php

namespace App\Models;



class Shipping extends BaseModel
{

  protected $fillable = ['userId', 'cartId', 'key', 'label', 'price', 'deliveryDate'];

  protected $rules = [
    
  ];

  
  public function rules()
  {
    return $this->rules;
  }

  public function getDependencies()
  {
    return [];
  }

  //belongsTo
  public function cart()
  {
    return $this->belongsTo(Cart::class, 'cartId');
  }


}
