<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained()->cascadeOnDelete();
            $table->string('source_name', 180);
            $table->string('source_url', 500);
            $table->unsignedSmallInteger('source_year')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
            $table->index(['career_id', 'source_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_sources');
    }
};
