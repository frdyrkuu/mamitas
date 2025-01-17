<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('category')->nullable();
            $table->string('sku');
            $table->string('supplier')->nullable();
            $table->string('product_unit');
            $table->string('color');
            $table->string('size');
            $table->string('barcode');
            $table->string('quantity')->nullable();
            $table->float('cost');
            $table->float('retail');
            $table->string('update_reason')->nullable();
            $table->string('image')->nullable(); // Adding the image column (nullable in case no image is provided)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
