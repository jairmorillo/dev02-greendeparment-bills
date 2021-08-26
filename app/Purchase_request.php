<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_request extends Model
{
    //

    protected $table = "request";

    protected $fillable = [
        'employer_id',
        'employer_name',
        'employer_phone',
        'employer_email',
        'employer_adress',
        'email_employer',
        'name_employer',
        'position_employer',
        'phone_employer',        
        'request_user_id',
        'request_type',
        'request_status',
        'request_number',
        'request_total',
        'request_subtotal',
        'request_tax',
        'request_taxes_num',
        'request_date'
    ];

}
