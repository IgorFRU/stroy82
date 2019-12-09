<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topmenus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->require();
            $table->integer('priority')->unsigned()->nullable()->default(1);
            $table->text('text')->nullable();
            $table->string('slug')->nullable();
            $table->integer('views')->default(0)->unsigned();
            $table->tinyInteger('published')->nullable()->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topmenus');
    }
}
