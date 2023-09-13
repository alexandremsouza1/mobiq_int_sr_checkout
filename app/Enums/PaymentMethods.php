<?php

namespace App\Enums;


enum PaymentMethods: string {
  case BankSlip = 'bankSlip';
  case Credit = 'credit';
  case Debit = 'debit';
  case Pix = 'pix';
  case Balance = 'balance';
}