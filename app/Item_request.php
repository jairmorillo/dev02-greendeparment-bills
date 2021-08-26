<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_request extends Model
{
    protected $table = "item_request";

    protected $fillable = [
        'id',
        'name',
        'description',
        'prices'        
    ];
}
