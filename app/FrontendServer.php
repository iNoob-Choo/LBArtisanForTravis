<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontendServer extends Model
{
  //change#1 removed name,ipaddress and added protocol
  protected $fillable = [
      'user_id','port_no','protocol','lb_id',
  ];
}
