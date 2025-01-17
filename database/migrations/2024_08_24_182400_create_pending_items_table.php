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
        Schema::create('pending_items', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('category');
            $table->string('supplier');
            $table->string('product_unit');
            $table->string('color');
            $table->string('size');
            $table->string('barcode');
            $table->string('quantity');
            $table->float('cost');
            $table->float('retail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_items');
    }
};
