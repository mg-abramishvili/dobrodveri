<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('main_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('header')->nullable();
            $table->string('text')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('main_sliders');
    }
};
