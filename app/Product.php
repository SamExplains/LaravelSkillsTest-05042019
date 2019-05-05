<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

  protected $redirectTo = '/daily-event';
  protected $fillable = ['product_name', 'quantity', 'price_per_item'];

}
