<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('company_name')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('theme')->nullable();
            $table->string('seo_desc')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('tg_token')->nullable();
            $table->string('tg_chat_id')->nullable();
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
