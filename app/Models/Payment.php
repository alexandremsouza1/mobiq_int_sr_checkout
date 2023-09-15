<?php

namespace App\Models;



class Payment extends BaseModel
{
  
  protected $fillable = ['id','cartId', 'paymentMethod', 'paymentCondition'];

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
