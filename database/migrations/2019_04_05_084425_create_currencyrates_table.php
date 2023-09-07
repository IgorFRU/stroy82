<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencyrates', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('currency_id');
            $table->double('value', 5, 2);
            $table->date('ondate');

            // $table->foreign('currency_id')
            //     ->references('id')
            //     ->on('currencies')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencyrates');
    }
}
