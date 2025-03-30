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
        Schema::create('gcash_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('sender_name')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('ticket_number'); // Store ticket number as string instead of foreign key
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();
            $table->string('ticket_number')->nullable()->change();
            $table->index('reference_number');
            $table->index('ticket_number');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gcash_transactions');
    }
};
