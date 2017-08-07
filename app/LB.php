<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LB extends Model
{
  protected $table = "LB";
  /*
  *vm_id is used for connecting to the api calls , each call need api_key and the respective id
  */
  /*
  Change#1 removed protocol and port number
  */
  protected $fillable = [
      'label_name', 'provider','user_id','ip_address','vm_id','location',
  ];
}
