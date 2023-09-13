<?php

namespace App\Enums;


enum CartStatus: string {
  case Open = 'open';
  case Closed = 'closed';
}