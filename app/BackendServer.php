<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackendServer extends Model
{

  protected $fillable = [
      'server_label_name', 'user_id','port_no','ip_address','frontend_id',
  ];
}
