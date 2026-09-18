<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->boolean('is_single_program')->default(false)->after('schedule_notes');
            $table->json('specialty_areas')->nullable()->after('is_single_program');
        });
    }

    public function down(): void
    {
        Schema::table('institutions', fn (Blueprint $table) => $table->dropColumn(['is_single_program', 'specialty_areas']));
    }
};
