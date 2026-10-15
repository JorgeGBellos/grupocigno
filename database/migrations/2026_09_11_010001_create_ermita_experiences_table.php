<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ermita_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->json('title');
            $table->json('paragraphs');
            $table->json('subtitle')->nullable();
            $table->json('subtitle_body')->nullable();
            $table->json('tag')->nullable();
            $table->json('cta')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('image')->nullable();
            $table->boolean('expandable')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ermita_experiences');
    }
};
