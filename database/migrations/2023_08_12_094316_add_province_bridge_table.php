<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvinceBridgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bridges', function (Blueprint $table) {
            $table->unsignedBigInteger('village_id')->nullable(); 
            $table->unsignedBigInteger('district_id')->nullable(); 
            $table->unsignedBigInteger('city_id')->nullable(); 
            $table->unsignedBigInteger('province_id')->nullable(); 
            $table->string('husband_name')->nullable();
            $table->string('wife_name')->nullable();
            $table->date('wedding_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
