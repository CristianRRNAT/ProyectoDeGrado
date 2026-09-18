<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->string('name', 180);
            $table->string('slug', 190)->unique();
            $table->string('acronym', 30)->nullable();
            $table->string('institution_type', 60);
            $table->string('ownership', 30)->nullable();
            $table->text('description')->nullable();
            $table->string('city', 80);
            $table->string('address', 255);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('source_url', 255)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['department_id', 'is_active']);
            $table->index(['institution_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
