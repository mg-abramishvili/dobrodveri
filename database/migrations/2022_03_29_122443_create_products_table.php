<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('category_id');
            $table->integer('style_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('construct_id')->nullable();
            $table->integer('surface_id')->nullable();
            $table->integer('factory_id')->nullable();
            $table->integer('price')->default('0');
            $table->decimal('old_price')->nullable();
            $table->longText('description')->nullable();
            $table->string('balance')->nullable();
            $table->boolean('hit')->nullable();
            $table->boolean('discount')->nullable();
            $table->boolean('sale')->nullable();
            $table->boolean('special')->nullable();
            $table->string('vkhod_image')->nullable();
            $table->string('napolnenie')->nullable();
            $table->string('tolschina_polotna')->nullable();
            $table->string('tolschina_metalla')->nullable();
            $table->string('vnutr_panel')->nullable();
            $table->string('zamok')->nullable();
            $table->string('termorazryv')->nullable();
            $table->string('noch_zadvizh')->nullable();
            $table->string('rebra_zh')->nullable();
            $table->integer('purpose_id')->nullable();
            $table->integer('furniture_type_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('view_counter')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
