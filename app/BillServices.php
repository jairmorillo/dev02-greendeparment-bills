<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class BillServices extends Model
{


    protected $table = "bill_services";

    protected $fillable = [
        'bill_id',
        'services_id',
        'serv_qty',
        'serv_name',
        'serv_description',
        'serv_unit',
        'serv_price',
        'serv_total_prices'
        ];
}
