<?php

namespace App\Models;



class Checkout extends BaseModel
{
  
  protected $fillable = ['cartId', 'userId', 'totalOriginal', 'total', 'status'];

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
