<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('logo',255)->nullable();
            $table->string('booth_number',30)->nullable();
            $table->string('booth_hall',30)->nullable();
            $table->string('email')->nullable();
            $table->string('phone',15)->nullable();
            $table->string('website')->nullable();
            $table->string('booth_map')->nullable();
            $table->boolean('featured')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
