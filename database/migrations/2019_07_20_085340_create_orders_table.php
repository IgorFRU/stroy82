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
            $table->string('number', 20);
            $table->unsignedBigInteger('orderstatus_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('firm_inn')->nullable();
            $table->enum('payment_method', ['on delivery', 'firm', 'online']);
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
