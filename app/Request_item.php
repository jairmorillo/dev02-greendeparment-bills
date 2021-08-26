<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request_item extends Model
{
    //

    protected $table = "request_item";

    protected $fillable = [
        'request_id',
        'request_items_id',
        'request_name',
        'request_description',
        'request_qty',        
        'request_price',
        'request_total_prices'  
        
    ];
}
