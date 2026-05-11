<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedBigInteger('category_id');
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->unsignedBigInteger('store_id');
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
