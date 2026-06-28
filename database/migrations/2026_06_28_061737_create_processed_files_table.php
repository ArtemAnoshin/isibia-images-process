<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processed_files', function (Blueprint $table) {
            $table->id();
            $table->string('anonymous_id', 64)->index();
            $table->foreignId('user_id')->nullable()->constrained();

            // Тип: 'single' - отдельный файл, 'archive' - архив с несколькими файлами
            $table->enum('type', ['single', 'archive'])->default('single');

            $table->string('original_name')->nullable();
            $table->string('path')->nullable();
            $table->integer('size')->nullable();

            $table->timestamp('expires_at');
            $table->timestamps();

            // Индексы
            $table->index(['anonymous_id', 'expires_at']);
            $table->index(['user_id', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processed_files');
    }
};
