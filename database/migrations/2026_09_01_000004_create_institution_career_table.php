<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institution_career', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('career_id')->constrained()->cascadeOnDelete();
            $table->string('modality', 50)->default('Presencial');
            $table->string('schedule', 100)->nullable();
            $table->string('duration_text', 80)->nullable();
            $table->decimal('enrollment_cost', 10, 2)->nullable();
            $table->decimal('monthly_cost', 10, 2)->nullable();
            $table->char('currency', 3)->default('BOB');
            $table->text('admission_requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['institution_id', 'career_id']);
            $table->index(['career_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_career');
    }
};
