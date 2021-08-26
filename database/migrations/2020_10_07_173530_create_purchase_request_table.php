<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->string('employer_id');
            $table->string('employer_name');
            $table->text('employer_adress');
            $table->string('employer_phone');
            $table->string('employer_email');
            $table->string('email_employer');
            $table->string('name_employer');
            $table->string('position_employer');
            $table->string('phone_employer');
            $table->string('request_user_id');
            $table->string('request_type');
            $table->string('request_status');
            $table->string('request_number');
            $table->string('request_description');
            $table->string('request_total');
            $table->string('request_subtotal');
            $table->string('request_tax');
            $table->string('request_taxes_num');
            $table->dateTime('request_date')->useCurrent();           
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
        Schema::dropIfExists('purchase_request');
    }
}
