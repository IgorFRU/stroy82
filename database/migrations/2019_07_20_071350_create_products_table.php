<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product');
            $table->string('product_pricename')->nullable();
            $table->string('slug')->nullable();
            $table->string('scu')->nullable();
            $table->string('autoscu', 20)->nullable();      // автоматически генерируемый уникальный артикул
            $table->bigInteger('category_id')->nullable()->unsigned();
            $table->bigInteger('manufacture_id')->nullable()->unsigned();
            $table->bigInteger('vendor_id')->nullable()->unsigned();
            $table->bigInteger('unit_id')->nullable()->unsigned();
            $table->bigInteger('discount_id')->nullable()->unsigned();
            $table->unsignedDecimal('size_l', 8, 3)->nullable(); //длина 
            $table->unsignedDecimal('size_w', 8, 3)->nullable(); //ширина 
            $table->unsignedDecimal('size_t', 8, 3)->nullable(); //толщина 
            $table->enum('size_type', ['mm', 'cm', 'm'])->nullable();
            $table->unsignedDecimal('mass', 8, 3)->nullable(); //масса 
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->tinyInteger('published')->nullable()->default(1)->unsigned();
            $table->boolean('pay_online')->nullable()->default(true);               // возможность оплаты онлайн
            $table->boolean('packaging')->nullable()->default(true);                // продажа только кратно упаковкам
            $table->unsignedDecimal('unit_in_package', 8, 3)->nullable();           // в одной упаковке ед.измерения
            $table->tinyInteger('amount_in_package')->nullable()->unsigned()->default(1);       // в одной упаковке штук
            $table->unsignedDecimal('price', 8, 2)->nullable();            
            $table->unsignedDecimal('quantity', 8, 3)->nullable();                  // кол-во в Симферополе            
            $table->unsignedDecimal('quantity_vendor', 8, 3)->nullable();                  // кол-во у поставщика            
            $table->integer('views')->default(0)->unsigned();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('manufacture_id')
                ->references('id')
                ->on('manufactures')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
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
        Schema::dropIfExists('products');
    }
}
