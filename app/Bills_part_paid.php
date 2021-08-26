<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bills_part_paid extends Model
{
     //

     protected $table = "bills_part_paid";

     protected $fillable = [
        'bill_id_p',
        'bill_number_p',
        'bill_total_p',
        'bill_subtotal_p',
        'bill_type_p',
        'partial_payment_percents',
        'partial_payment_cash',        
        'partial_payment_mont',
        'partial_payment_rest',
        'partial_payment_date'        
         ];


    
}
