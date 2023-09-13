<?php

namespace App\Models;



class CartItem extends BaseModel
{
  
  protected $fillable = ['cartId', 'productId', 'quantity', 'price', 'weight', 'label'];

  protected $dates = ['created_at', 'updated_at'];

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


  public function product()
  {
    return $this->belongsTo(Product::class, 'productId');
  }
}
