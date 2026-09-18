<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institution_career', function (Blueprint $table) {
            $table->string('academic_regime', 40)->nullable()->after('schedule');
            $table->string('details_source_url')->nullable()->after('admission_requirements');
            $table->timestamp('details_verified_at')->nullable()->after('details_source_url');
        });

        DB::table('institutions')->select('id', 'schedule_notes')->orderBy('id')->each(function ($institution) {
            $schedule = trim((string) $institution->schedule_notes);
            if ($schedule !== '' && preg_match('/mañana|noche|diurno|nocturno/iu', $schedule) && !preg_match('/consultar|varían|varian/iu', $schedule)) {
                DB::table('institution_career')
                    ->where('institution_id', $institution->id)
                    ->where(function ($query) {
                        $query->whereNull('schedule')->orWhere('schedule', 'like', '%Consultar%');
                    })
                    ->update(['schedule' => $schedule]);
            }
        });

        DB::table('institution_career')->select('id', 'duration_text')->orderBy('id')->each(function ($offering) {
            $duration = (string) $offering->duration_text;
            $regime = preg_match('/semestres?/iu', $duration) ? 'Semestral' : (preg_match('/régimen anual|regimen anual/iu', $duration) ? 'Anual' : null);
            if ($regime) {
                DB::table('institution_career')->where('id', $offering->id)->update(['academic_regime' => $regime]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('institution_career', function (Blueprint $table) {
            $table->dropColumn(['academic_regime', 'details_source_url', 'details_verified_at']);
        });
    }
};
