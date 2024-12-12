<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('unit_price', 10, 2); // Unit price at the time of order
            $table->decimal('discount', 5, 2)->default(0); // Discount applied to the product
            $table->decimal('tax', 5, 2)->default(0); // Tax applied to the product
            $table->decimal('total_price', 10, 2); // Total price for this item (quantity * unit_price - discount + tax)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
