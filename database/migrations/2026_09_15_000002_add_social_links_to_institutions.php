<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->string('whatsapp_url')->nullable()->after('website');
            $table->string('facebook_url')->nullable()->after('whatsapp_url');
            $table->string('tiktok_url')->nullable()->after('facebook_url');
        });

        DB::table('institutions')->where('website', 'like', '%facebook.com%')->orderBy('id')->each(function ($institution) {
            DB::table('institutions')->where('id', $institution->id)->update([
                'facebook_url' => $institution->website,
                'website' => null,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('institutions', fn (Blueprint $table) => $table->dropColumn(['whatsapp_url', 'facebook_url', 'tiktok_url']));
    }
};
