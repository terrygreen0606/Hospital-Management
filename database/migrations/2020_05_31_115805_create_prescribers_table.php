<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->date("created_time")->nullable();
            $table->string('status')->nullable();
            $table->string("assigned_to")->nullable();
            $table->string("prescribers_no")->nullable();
            $table->string("created_by")->nullable();
            $table->date("modified_time")->nullable();
            $table->string("last_modified_by")->nullable();
            $table->string("source")->nullable();
            $table->string("dps")->nullable();
            $table->string("dea")->nullable();
            $table->string("classification")->nullable();
            $table->string("upin")->nullable();
            $table->string("group_code")->nullable();
            $table->string("alternate_id")->nullable();
            $table->string("legacy_number")->nullable();
            $table->string("npi")->nullable();
            $table->string("primary_address")->nullable()->nullable();
            $table->string("name")->nullable();
            $table->string("address")->nullable();
            $table->string("prescriber_type")->nullable();
            $table->string("suite_no")->nullable();
            $table->string("phone")->nullable();
            $table->string("city")->nullable();
            $table->string("fax")->nullable();
            $table->string("state")->nullable();
            $table->string("specialization")->nullable();
            $table->string("zip_code")->nullable();
            $table->string("state_license")->nullable();
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
        Schema::dropIfExists('prescribers');
    }
}
