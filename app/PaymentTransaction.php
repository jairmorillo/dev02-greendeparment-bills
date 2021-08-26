<?php
// Path: app/PaymentLogs.php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_transaction';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'payment_bill_id',
        'payment_bill_code',
        'payment_bill_customer',
        'payment_bill_description',
        'payment_bill_total',
        'payment_partial_payment_mont',
        'payment_partial_payment_rest',
        'payment_transaction_status',
        'payment_response_code',
        'payment_transaction_id',
        'payment_auth_id',
        'payment_message_code',
        'payment_name_on_card',
        'payment_token',
        'payment_quantity'      

    ];
        
}