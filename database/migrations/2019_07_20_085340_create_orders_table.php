<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number')->unsigned();
            $table->unsignedBigInteger('orderstatus_id')->nullable();
            $table->enum('payment_method', ['online', 'on delivery']);
            $table->boolean('successful_payment')->nullable()->default(false);
            $table->boolean('completed')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('orderstatus_id')
                ->references('id')
                ->on('orderstatuses')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
