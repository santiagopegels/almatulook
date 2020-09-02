<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('value_id');

            $table->foreign('attribute_id')->references('id')->on('attributes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('value_id')->references('id')->on('values')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('attribute_value');
    }
}
