<?php

namespace App\Models;



class Cart extends BaseModel
{
  
  protected $fillable = ['id','customerId', 'totalOriginal', 'total', 'status'];

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

  //hasMany items
  public function items()
  {
    return $this->hasMany(CartItem::class, 'cartId');
  }


  //customer
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'customerId');
  }

  //payment
  public function payment()
  {
    return $this->hasOne(Payment::class, 'cartId');
  }
}
