<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesValuesGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_values_group', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('attribute_value_id');
            $table->integer('group_id');
            $table->timestamps();
        });

        Schema::table('attributes_values_group', function($table) {
            $table->foreign('attribute_value_id')->references('id')->on('attributes_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes_values_group');
    }
}
