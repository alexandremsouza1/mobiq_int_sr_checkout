<?php

namespace App\Models\Types;

use App\Enums\PaymentMethods;
use Illuminate\Validation\Rules\Enum;
use App\Models\BaseModel;

class Pix extends BaseModel
{
  
  protected $fillable = ['userId', 'paymentId', 'type', 'base64QrCode', 'key', 'txId', 'amount'];


  public function rules()
  {
    return [
      'type' => ['required', new Enum(PaymentMethods::class)]
    ];
  }


  public function getDependencies()
  {
    return [];
  }

  //belongsTo
  public function payment()
  {
    return $this->belongsTo(Payment::class, 'paymentId');
  }


}
