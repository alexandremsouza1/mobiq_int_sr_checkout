<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Customer extends BaseModel
{
  
  protected $fillable = ['cartId', 'clientId', 'info'];

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


  public function setInfoAttribute($value)
  {
    $string = json_encode($value);
    $this->attributes['info'] = Crypt::encryptString($string);
  }

  public function getInfoAttribute()
  {
    $string = Crypt::decryptString($this->attributes['info']);
    return json_decode($string);
  }
}
