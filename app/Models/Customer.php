<?php

namespace App\Models;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Customer extends BaseModel
{
  
  protected $fillable = ['clientId', 'info'];

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

  public function setInfoAttribute($value)
  {
    $this->attributes['info'] = json_encode($value);
  }
}
