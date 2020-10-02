<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchiveOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_orders', function (Blueprint $table) {
            $table->id();
            $table->string('rx_number')->nullable();
            $table->string('prescriber_full_name')->nullable();
            $table->string('prescriber_npi')->nullable();
            $table->string('prescriber_primary_city')->nullable();
            $table->string('prescriber_primary_state')->nullable();
            $table->string('date_filled')->nullable();
            $table->string('refill_or_new')->nullable();
            $table->string('dispensed_item_name')->nullable();
            $table->string('dispensed_item_ndc')->nullable();
            $table->string('dispensed_item_dosage_form')->nullable();
            $table->string('dispensed_item_stock_size')->nullable();
            $table->string('dispensed_quantity')->nullable();
            $table->string('pay_method')->nullable();
            $table->string('primary')->nullable();
            $table->string('pharmacy')->nullable();
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
        Schema::dropIfExists('archive_orders');
    }
}
