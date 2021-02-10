<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->date('purchase_date');
            $table->float('total');

            $table->unsignedInteger('shipment_type_id');
            $table->foreign('shipment_type_id')->references('id')->on('shipment_types')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->float('shipment_cost');

            $table->unsignedSmallInteger('status_order');
            $table->foreign('status_order')->references('order')->on('status_orders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedSmallInteger('profile_id');
            $table->foreign('status_order')->references('order')->on('status_orders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('preference_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchases');
    }
}
