<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannertagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bannertags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text', 191);
            $table->string('background', 20)->default('#4682B4');
            $table->string('color', 20)->default('#ffffff');
            $table->integer('priority')->unsigned()->nullable();
            $table->integer('padding')->unsigned()->default(5);
            $table->string('rounded')->nullable()->default('');
            $table->string('shadow')->nullable()->default('');
            $table->unsignedBigInteger('banner_id');
            $table->timestamps();

            $table->foreign('banner_id')
                ->references('id')
                ->on('banners')
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
        Schema::dropIfExists('bannertags');
    }
}
