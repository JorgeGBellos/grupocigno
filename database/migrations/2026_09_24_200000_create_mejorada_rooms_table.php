<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mejorada_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->json('title');
            $table->json('body');
            $table->json('detail');
            $table->json('price');
            $table->json('size');
            $table->unsignedTinyInteger('people');
            $table->unsignedTinyInteger('beds');
            $table->json('exclusive')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mejorada_rooms');
    }
};
