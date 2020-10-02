<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDCWithVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n_d_c_with_videos', function (Blueprint $table) {
            $table->id();
            $table->string('ncd9_formatted');
            $table->string('name');
            $table->string('dosage_form_name');
            $table->string('route_name');
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
        Schema::dropIfExists('n_d_c_with_videos');
    }
}
