<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->string('image_url', 1000)->nullable()->after('official_url');
        });

        Schema::table('learning_videos', function (Blueprint $table) {
            $table->string('section_type', 20)->default('course')->index()->after('career_area');
        });

        Schema::create('opportunity_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name', 120);
            $table->string('email', 160);
            $table->string('phone', 30);
            $table->string('organization_type', 30);
            $table->string('organization_name', 180);
            $table->string('opportunity_type', 20);
            $table->string('status', 20)->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunity_submissions');
        Schema::table('learning_videos', fn (Blueprint $table) => $table->dropColumn('section_type'));
        Schema::table('opportunities', fn (Blueprint $table) => $table->dropColumn('image_url'));
    }
};
