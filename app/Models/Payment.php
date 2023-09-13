<?php

namespace App\Models;



class Payment extends BaseModel
{
  
  protected $fillable = ['userId', 'cartId', 'type', 'amount', 'status'];

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
