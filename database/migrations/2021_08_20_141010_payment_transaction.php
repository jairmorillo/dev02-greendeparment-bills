<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount',8,2);
            $table->string('payment_bill_id')->nullable(); 
            $table->string('payment_bill_code')->nullable();
            $table->string('payment_bill_customer')->nullable();            
            $table->string('payment_bill_description')->nullable();            
            $table->string('payment_bill_total')->nullable(); 
            $table->string('payment_partial_payment_mont')->nullable();        
            $table->string('payment_partial_payment_rest')->nullable();
            $table->string('payment_transaction_status')->nullable();
            $table->string('payment_response_code')->nullable();            
            $table->string('payment_transaction_id')->nullable();            
            $table->string('payment_auth_id')->nullable();            
            $table->string('payment_message_code')->nullable();   
            $table->string('payment_name_on_card')->nullable();            
            $table->string('payment_token')->nullable();            
            $table->integer('payment_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
