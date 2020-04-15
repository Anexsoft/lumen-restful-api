<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('orders_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');        
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('orders_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');        
            $table->foreign('order_id')->references('id')->on('orders');

            $table->unsignedBigInteger('product_id');        
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('orders');
        Schema::dropIfExists('orders_detail');

        Schema::enableForeignKeyConstraints();
    }
}
