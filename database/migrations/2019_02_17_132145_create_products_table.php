<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('product_name');//should name
            $table->string('catagory_id');
            $table->mediumText('description');
            $table->integer('stock');
            $table->float('price', 8, 2);
            $table->unsignedInteger('percentage_discount');
            $table->float('real_price');
            $table->integer('enable_display');
            $table->string('image_source');
            $table->string('auxiliary_image_source');

            $table->timestamps();
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
