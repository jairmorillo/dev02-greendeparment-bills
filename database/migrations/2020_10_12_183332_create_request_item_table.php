<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('request_id');
            $table->unsignedInteger('request_items_id');
            $table->string('request_qty');
            $table->string('request_name');
            $table->string('request_description');           
            $table->string('request_price');
            $table->string('request_total_prices');
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
        Schema::dropIfExists('request_item');
    }
}
