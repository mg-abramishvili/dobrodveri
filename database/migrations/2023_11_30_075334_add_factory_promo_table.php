<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factory_promo', function (Blueprint $table) {
            $table->id();
            $table->integer('promo_id');
            $table->integer('factory_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factory_promo');
    }
};
