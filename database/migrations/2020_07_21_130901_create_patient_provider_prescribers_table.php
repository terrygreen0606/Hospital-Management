<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientProviderPrescribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_provider_prescribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->foreignId('provider_id');
            $table->foreignId('prescriber_id');
            $table->foreignId('order_id');
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
        Schema::dropIfExists('patient_provider_prescribers');
    }
}
