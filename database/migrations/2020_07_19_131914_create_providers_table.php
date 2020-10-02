<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string('name');
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zipcode")->nullable();
            $table->string("ncpdp")->nullable();
            $table->string("npi")->nullable();
            $table->string("dea")->nullable();
            $table->string("pharmacy_pioneer_rx_id")->nullable();
            $table->string("web_address")->nullable();
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
        Schema::dropIfExists('providers');
    }
}
