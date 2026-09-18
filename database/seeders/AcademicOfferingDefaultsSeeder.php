<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicOfferingDefaultsSeeder extends Seeder
{
    public function run(): void
    {
        $itsaNightPrograms = [
            'informatica-industrial',
            'mecanica-automotriz',
            'secretariado-ejecutivo',
            'sistemas-informaticos',
            'topografia-y-geodesia',
        ];

        $itsaId = DB::table('institutions')->where('slug', 'instituto-tecnologico-superior-amazonia-itsa')->value('id');
        if ($itsaId) {
            DB::table('careers')->whereIn('slug', $itsaNightPrograms)->get(['id'])->each(function ($career) use ($itsaId) {
                DB::table('institution_career')->updateOrInsert(
                    ['institution_id' => $itsaId, 'career_id' => $career->id],
                    [
                        'degree_level' => 'Técnico Superior',
                        'modality' => 'Presencial',
                        'schedule' => 'Mañana y noche',
                        'academic_regime' => 'Anual',
                        'duration_text' => '3 años',
                        'labor_demand' => 'Variado',
                        'is_active' => true,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            });
        }

        DB::table('institution_career')
            ->join('institutions', 'institutions.id', '=', 'institution_career.institution_id')
            ->join('careers', 'careers.id', '=', 'institution_career.career_id')
            ->select([
                'institution_career.id', 'institution_career.schedule', 'institution_career.duration_text',
                'institution_career.degree_level', 'institutions.slug as institution_slug',
                'institutions.institution_type', 'careers.slug as career_slug', 'careers.name as career_name',
            ])
            ->orderBy('institution_career.id')
            ->chunk(200, function ($offerings) use ($itsaNightPrograms) {
                foreach ($offerings as $offering) {
                    $type = mb_strtolower((string) $offering->institution_type);
                    $level = mb_strtolower((string) $offering->degree_level);
                    $name = mb_strtolower((string) $offering->career_name);
                    $isUniversity = str_contains($type, 'universidad');
                    $isItsa = $offering->institution_slug === 'instituto-tecnologico-sacaba';

                    $schedule = trim((string) $offering->schedule);
                    if ($isItsa && in_array($offering->career_slug, $itsaNightPrograms, true)) {
                        $schedule = 'Noche';
                    } elseif ($schedule === '' || preg_match('/consultar|por confirmar/iu', $schedule)) {
                        $schedule = 'Mañana y noche';
                    }

                    $duration = trim((string) $offering->duration_text);
                    if ($duration === '' || preg_match('/consultar|por confirmar|según plan|segun plan/iu', $duration)) {
                        $duration = $this->estimatedDuration($isUniversity, $level, $name, $offering->career_slug);
                    }

                    DB::table('institution_career')->where('id', $offering->id)->update([
                        'schedule' => $schedule,
                        'academic_regime' => $isUniversity ? 'Semestral' : 'Anual',
                        'duration_text' => $duration,
                    ]);
                }
            });
    }

    private function estimatedDuration(bool $isUniversity, string $level, string $name, string $slug): string
    {
        if (!$isUniversity) {
            if (str_contains($level, 'licenciatura')) return '5 años aprox.';
            if (str_contains($level, 'medio')) return '2 años aprox.';
            return '3 años aprox.';
        }

        if ($slug === 'medicina') return '6 años aprox. (incluye internado)';
        if (str_contains($level, 'técnico') || str_contains($level, 'tecnico')) return '3 años aprox.';
        if (str_contains($name, 'ingeniería') || str_contains($name, 'ingenieria') || str_contains($name, 'arquitectura') || str_contains($name, 'odontología') || str_contains($name, 'odontologia') || str_contains($name, 'veterinaria')) return '5 años aprox.';
        return '4 a 5 años aprox.';
    }
}
