<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_area_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 160)->unique();
            $table->string('slug', 170)->unique();
            $table->json('alternative_names')->nullable();
            $table->string('degree_level', 80);
            $table->string('duration_text', 80)->nullable();
            $table->string('riasec_primary', 1)->nullable();
            $table->string('riasec_secondary', 1)->nullable();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->longText('professional_field')->nullable();
            $table->string('source_url', 255)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['academic_area_id', 'is_active']);
            $table->index(['riasec_primary', 'riasec_secondary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
