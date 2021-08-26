<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
     //
     protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_adress',
        'customer_phone',
        'customer_email',
        'customer_type_property',
        'bill_number',
        'bill_description',
        'bill_total',
        'bill_subtotal',
        'bill_iva',
        'bill_discount',
        'partial_payment_percents',
        'partial_payment_cash',        
        'partial_payment_mont',
        'partial_payment_rest',
        'bill_date',
        'bill_user_id',
        'bill_type',
        'tasa' , 
        'discount',
        'discount_cash'
    ];


    
}
