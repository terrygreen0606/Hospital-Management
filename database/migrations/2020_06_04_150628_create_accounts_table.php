<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->string('name');
            $table->double('main')->default(0.00);
            $table->double('bonus')->default(0.00);
            $table->foreign("owner_id")
                ->references("id")
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("alter table accounts add column balance double(15,4) as (main + bonus );");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
