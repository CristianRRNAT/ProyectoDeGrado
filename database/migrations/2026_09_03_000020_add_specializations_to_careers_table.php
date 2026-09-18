<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('careers', fn (Blueprint $table) => $table->json('specializations')->nullable()->after('study_focus')); }
    public function down(): void { Schema::table('careers', fn (Blueprint $table) => $table->dropColumn('specializations')); }
};
