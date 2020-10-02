<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formularies', function (Blueprint $table) {
            $table->id();
            $table->string('drug_name');
            $table->string('strength');
            $table->string('form');
            $table->string('qty');
            $table->string('disease_state');
            $table->string('premium');
            $table->string('non_premium');
            $table->string('category');
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
        Schema::dropIfExists('formularies');
    }
}
