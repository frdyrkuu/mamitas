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
        Schema::create('tbl_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('cashier');
            $table->string('POS_number');
            $table->integer('starting_cash');
            $table->integer('closing_cash');
            $table->integer('cash_in')->nullable();
            $table->integer('cash_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_shifts');
    }
};
