<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
                $table->bigIncrements('id');
                $table->string('user_type', 20)->comment('user,admin');
                $table->string('first_name', 50);
                $table->string('last_name', 50);
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('company_name')->nullable();
                $table->string('city', 30)->nullable();
                $table->string('avatar', 100)->nullable();
                $table->string('device_type', 10)->nullable();
                $table->string('device_token')->nullable();

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
