<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
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
            $table->string('vendor');
            $table->string('address')->nullable();
            $table->string('site')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('email_id')->nullable()->unsigned()->unique();
            $table->bigInteger('phone_id')->nullable()->unsigned()->unique();
            $table->integer('price_name')->nullable();
            $table->timestamps();

            $table->foreign('email_id')
                ->references('id')
                ->on('emails')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('phone_id')
                ->references('id')
                ->on('phones')
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
        Schema::dropIfExists('vendors');
    }
}
