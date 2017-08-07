<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIKEY extends Model
{
  protected $table = "apikey";
  protected $fillable = [
      'API_KEY', 'provider','user_id',
  ];
}
