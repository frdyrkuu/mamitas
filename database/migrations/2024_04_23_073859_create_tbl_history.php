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
        Schema::create('tbl_history', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket');
            $table->string('cashier');
            $table->string('customer');
            $table->string('type');
            $table->double('sub_total');
            $table->double('tax');
            $table->double('cash');
            $table->double('total');
            $table->double('change');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_history');
    }
};
