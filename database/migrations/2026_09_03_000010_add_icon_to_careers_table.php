<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('icon', 60)->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('careers', fn (Blueprint $table) => $table->dropColumn('icon'));
    }
};
