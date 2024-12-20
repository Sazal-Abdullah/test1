<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->string('name');
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->decimal('discounted_price', 10, 2);
        $table->decimal('total_price', 10, 2)->default(0);
        $table->unsignedBigInteger('user_id')->nullable(); // Optional: For logged-in users
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
