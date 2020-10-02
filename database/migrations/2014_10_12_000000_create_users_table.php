<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid')->nullable();
            $table->string('avatar')->default('https://api.adorable.io/avatars/285/');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('dob')->nullable();
            $table->string('otp')->nullable();
            $table->string('role')->nullable()->default('patient');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
