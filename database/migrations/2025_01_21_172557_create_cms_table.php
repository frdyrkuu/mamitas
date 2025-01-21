<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTable extends Migration
{
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->id(); // Auto-increment ID (primary key)
            $table->string('company_name'); // Company Name
            $table->string('company_logo')->nullable(); // Company Logo (optional, in case the logo is not uploaded)
            $table->text('company_description')->nullable(); // Company Description
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('cms');
    }
}
