<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIncomingPriceColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedDecimal('incomin_price', 8, 2)->nullable()->after('price');
            $table->unsignedDecimal('profit', 8, 2)->nullable();
            $table->enum('profit_type', ['%', 'rub'])->default('%')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['incomin_price', 'profit', 'profit_type']);
        });
    }
}
