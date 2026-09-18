<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id(); $table->string('type', 20)->index(); $table->string('title'); $table->string('slug')->unique();
            $table->string('provider'); $table->text('description'); $table->string('modality', 40)->nullable();
            $table->string('cost_type', 20); $table->decimal('cost_amount', 10, 2)->nullable(); $table->string('currency', 3)->default('BOB');
            $table->string('duration')->nullable(); $table->string('audience')->nullable(); $table->text('requirements')->nullable();
            $table->text('application_process')->nullable(); $table->string('contact')->nullable(); $table->string('location')->nullable();
            $table->date('start_date')->nullable(); $table->date('deadline')->nullable(); $table->string('availability_status', 30)->default('consult');
            $table->string('promotion_text')->nullable(); $table->string('official_url'); $table->timestamp('verified_at')->nullable();
            $table->boolean('is_verified')->default(false); $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('learning_videos', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->string('youtube_id', 20)->unique(); $table->string('channel');
            $table->string('career_area'); $table->text('description')->nullable(); $table->boolean('is_active')->default(true); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('learning_videos'); Schema::dropIfExists('opportunities'); }
};
