<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->string('slug', 50)->unique();
            $table->string('capital', 60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('academic_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('slug', 90)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 40)->nullable();
            $table->string('color', 7)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_areas');
        Schema::dropIfExists('departments');
    }
};
