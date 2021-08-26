<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->text('customer_adress');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('customer_type_property');
            $table->string('bill_number');
            $table->string('bill_description');
            $table->string('bill_total');
            $table->string('bill_subtotal');
            $table->string('bill_iva');	
            $table->string('bill_discount');
            $table->string('partial_payment_percents');
            $table->string('partial_payment_mont');
            $table->string('partial_payment_rest');
            $table->dateTime('bill_date')->useCurrent();
            $table->string('bill_user_id');
            $table->string('bill_type');
            $table->string('tasa');
            $table->string('discount');
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
        Schema::dropIfExists('bill');
    }
}
