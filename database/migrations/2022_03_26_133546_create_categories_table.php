<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->string('image')->nullable();
            $table->string('short_description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
