<?php

namespace App;

use Illuminate\Database\Eloquent\Model;  

class Customer extends Model
{

    protected $table = "customers";
    

    protected $fillable = [
        'cust_name',
        'cust_adress',
        'cust_phone',
        'cust_email',
        'cust_type_property'
    ];


}
