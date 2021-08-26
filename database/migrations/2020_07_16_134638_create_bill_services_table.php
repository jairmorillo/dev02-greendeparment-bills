<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('bill_id');
            $table->unsignedInteger('services_id');
            $table->string('serv_qty');
            $table->string('serv_name');
            $table->string('serv_description');           
            $table->string('serv_price');
            $table->string('serv_total_prices');
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
        Schema::dropIfExists('bill_services');
    }
}
