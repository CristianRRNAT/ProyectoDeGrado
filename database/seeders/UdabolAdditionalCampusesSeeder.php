<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Institution;
use App\Models\InstitutionUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UdabolAdditionalCampusesSeeder extends Seeder
{
    public function run(): void
    {
        // Oferta por ciudad y direcciones publicadas por UDABOL, consultadas el 11-09-2026.
        // https://www.udabol.edu.bo/estudia-en-udabol/ofertas-academicas
        DB::transaction(function () {
            $institution = Institution::where('slug', 'universidad-de-aquino-bolivia')->first();
            if (! $institution) {
                return;
            }
            $programs = json_decode(file_get_contents(database_path('data/udabol-additional-programs.json')), true, 512, JSON_THROW_ON_ERROR);
            $aliases = [
                'ingenieria-telecomunicaciones' => 'ingenieria-de-telecomunicaciones',
                'ingenieria-sistemas' => 'ingenieria-de-sistemas',
                'administracion-empresas' => 'administracion-de-empresas',
                'fisioterapia-kinesiologia' => 'fisioterapia-y-kinesiologia',
                'auditoria' => 'contaduria-publica',
                'comunicacion' => 'comunicacion-social',
                'marketing-publicidad' => 'marketing-y-publicidad',
                'ingenieria-gas-petroleo' => 'ingenieria-de-petroleo-y-gas-natural',
                'bioquimica-farmacia' => 'bioquimica',
            ];
            foreach ($programs as $program) {
                $base = preg_replace('/-(lp|oruro)$/', '', $program['source_slug']);
                $career = Career::firstOrCreate(['slug' => $aliases[$base] ?? $base], [
                    'name' => $program['name'],
                    'degree_level' => 'Licenciatura',
                    'duration_text' => $program['duration'],
                    'reference_title' => $program['degree_title'],
                    'summary' => 'Programa de licenciatura registrado en la oferta académica de UDABOL.',
                    'source_url' => 'https://www.udabol.edu.bo/estudia-en-udabol/ofertas-academicas/'.$program['source_slug'],
                    'is_active' => true,
                ]);
                // No modificar la información de una carrera que ya está asociada.
                if (! $institution->careers()->where('careers.id', $career->id)->exists()) {
                    $institution->careers()->attach($career->id, [
                        'degree_level' => 'Licenciatura', 'modality' => 'Presencial',
                        'duration_text' => $program['duration'], 'is_active' => true,
                    ]);
                }
            }

            $faculties = [
                'Facultad de Ciencias de la Salud' => [
                    'medicina', 'odontologia', 'enfermeria', 'bioquimica',
                    'fisioterapia-y-kinesiologia',
                ],
                'Facultad de Ciencias Sociales y Humanísticas' => [
                    'derecho', 'psicologia', 'comunicacion-social', 'turismo',
                ],
                'Facultad de Ciencias Económicas y Financieras' => [
                    'administracion-de-empresas', 'ingenieria-comercial',
                    'marketing-y-publicidad', 'contaduria-publica',
                ],
                'Facultad de Ciencia y Tecnología' => [
                    'ingenieria-de-sistemas', 'ingenieria-de-telecomunicaciones',
                    'ingenieria-de-petroleo-y-gas-natural', 'ingenieria-ambiental',
                ],
                'Facultad de Teología, Filosofía y Letras' => ['liderazgo-pastoral'],
                'Facultad de Arquitectura, Hábitat y Diseño' => ['arquitectura'],
            ];

            $sortOrder = 1;
            foreach ($faculties as $facultyName => $careerSlugs) {
                $unit = InstitutionUnit::updateOrCreate(
                    ['institution_id' => $institution->id, 'slug' => Str::slug($facultyName)],
                    [
                        'name' => $facultyName,
                        'unit_type' => 'Facultad',
                        'sort_order' => $sortOrder++,
                        'is_active' => true,
                    ]
                );

                DB::table('institution_career')
                    ->where('institution_id', $institution->id)
                    ->whereIn('career_id', Career::whereIn('slug', $careerSlugs)->select('id'))
                    ->update(['institution_unit_id' => $unit->id]);
            }

            // Este agrupador genérico provenía de una sede consolidada y no es una facultad real.
            $genericUnit = $institution->units()->where('slug', 'oferta-academica')->first();
            if ($genericUnit) {
                DB::table('institution_career')
                    ->where('institution_id', $institution->id)
                    ->where('institution_unit_id', $genericUnit->id)
                    ->update(['institution_unit_id' => null]);
                $genericUnit->delete();
            }

            $campuses = collect($institution->campuses ?? []);
            foreach ([
                ['La Paz', 'la-paz', 'Capitán Ravelo, Pasaje Isaac Eduardo N.º 2643, Edificio UDABOL'],
                ['Oruro', 'oruro', 'Calle 6 de Octubre N.º 4966, entre Aroma y Belzu, Edificio UDABOL'],
            ] as [$city, $department, $address]) {
                $campuses = $campuses->reject(fn ($campus) => ($campus['department_slug'] ?? null) === $department && ($campus['city'] ?? null) === $city);
                $campuses->push([
                    'name' => 'Sede '.$city, 'city' => $city, 'department' => $city,
                    'department_slug' => $department, 'address' => $address,
                    'source_url' => 'https://www.udabol.edu.bo/estudia-en-udabol/sedes/'.$department,
                    'programs' => collect($programs)->where('department_slug', $department)->pluck('name')->unique()->values()->all(),
                ]);
            }
            $institution->update(['campuses' => $campuses->values()->all()]);
        });
    }
}
