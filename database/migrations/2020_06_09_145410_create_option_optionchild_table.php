<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionOptionchildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_optionchild', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('option_id');
            $table->unsignedBigInteger('child_id');
            $table->string('scu')->nullable();
            $table->string('autoscu', 20)->nullable();
            $table->double('price', 9, 2)->nullable();
            
            $table->foreign('option_id')
                ->references('id')
                ->on('options')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('child_id')
                ->references('id')
                ->on('options')
                ->onDelete('cascade')
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
        Schema::dropIfExists('option_optionchild');
    }
}
