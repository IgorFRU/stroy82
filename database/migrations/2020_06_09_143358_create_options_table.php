<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('typeoption_id')->nullable()->unsigned()->default(0);
            $table->string('option', 191);
            $table->enum('type', ['photo', 'text']);
            $table->boolean('name_plus')->default(true);
            $table->string('scu')->nullable();
            $table->string('autoscu', 20)->nullable();
            $table->double('price', 9, 2)->nullable();
            $table->string('photo')->nullable();
            $table->string('color', 10)->nullable();
            $table->boolean('main')->default(true);
            $table->timestamps();

            $table->foreign('typeoption_id')
                ->references('id')
                ->on('typeoptions')
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
        Schema::dropIfExists('options');
    }
}
