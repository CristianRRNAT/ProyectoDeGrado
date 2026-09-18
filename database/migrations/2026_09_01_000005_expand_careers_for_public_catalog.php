<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->boolean('is_traditional')->default(true)->after('degree_level');
            $table->decimal('duration_min_years', 3, 1)->nullable()->after('duration_text');
            $table->decimal('duration_max_years', 3, 1)->nullable()->after('duration_min_years');
            $table->string('reference_title', 150)->nullable()->after('duration_max_years');
            $table->longText('study_focus')->nullable()->after('description');
            $table->longText('economic_scope')->nullable()->after('professional_field');
            $table->longText('social_scope')->nullable()->after('economic_scope');
            $table->longText('international_scope')->nullable()->after('social_scope');
            $table->string('cover_image', 255)->nullable()->after('international_scope');
            $table->json('gallery_images')->nullable()->after('cover_image');
        });

        Schema::table('institution_career', function (Blueprint $table) {
            $table->string('degree_level', 80)->nullable()->after('career_id');
        });
    }

    public function down(): void
    {
        Schema::table('institution_career', fn (Blueprint $table) => $table->dropColumn('degree_level'));
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn(['is_traditional', 'duration_min_years', 'duration_max_years', 'reference_title', 'study_focus', 'economic_scope', 'social_scope', 'international_scope', 'cover_image', 'gallery_images']);
        });
    }
};
