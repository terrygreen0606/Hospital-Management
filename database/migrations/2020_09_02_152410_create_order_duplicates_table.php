<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDuplicatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_duplicates', function (Blueprint $table) {
            $table->id();
            $table->longText('data');
            $table->string('status');
            $table->string('name')->nullable();
            $table->string('prescriber_name')->nullable();
            $table->string('rx_number')->nullable();
            $table->string('current_transaction_status_date')->nullable();
            $table->string('priority')->nullable();
            $table->string('dispensed_item_name')->nullable();
            $table->string('current_transaction_status')->nullable();
            $table->string('date_filled')->nullable();
            $table->string('date_written')->nullable();
            $table->string('rx_status')->nullable();
            $table->string('rx_status_changed_on')->nullable();
            $table->string('number_of_refills_allowed')->nullable();
            $table->string('directions_translated')->nullable();
            $table->string('rx_total_quantity_remaining')->nullable();
            $table->string('refills_remaining')->nullable();
            $table->string('refill_number')->nullable();
            $table->string('dispensed_quantity')->nullable();
            $table->string('days_supply')->nullable();
            $table->string('total_price_paid')->nullable();
            $table->string('patient_paid_amount')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('dispensed_item_ndc')->nullable();
            $table->string('prescriber_npi')->nullable();
            $table->string('pharmacy_name')->nullable();
            $table->string('tracking_number')->nullable();
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
        Schema::dropIfExists('order_duplicates');
    }
}
