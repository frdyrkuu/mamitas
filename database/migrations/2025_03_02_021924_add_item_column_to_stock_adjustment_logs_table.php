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
        Schema::table('stock_adjustment_logs', function (Blueprint $table) {
            $table->string('item')->after('stock_id'); // Add item column
        });
    }
    
    public function down()
    {
        Schema::table('stock_adjustment_logs', function (Blueprint $table) {
            $table->dropColumn('item');
        });
    }
 
};
