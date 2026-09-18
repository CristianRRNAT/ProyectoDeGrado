<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\CareerSource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VerifiedNationalCareersSeeder extends Seeder
{
    private const UNIVERSITY_URL = 'https://www.minedu.gob.bo/files/GUIA-UNIVERSIDADES.pdf';
    private const TECHNICAL_URL = 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run(): void
    {
        $university = [
            ['Actividad Física y del Deporte','Salud y bienestar','S','R'],
            ['Administración Agropecuaria','Agropecuaria y medio ambiente','E','R'],
            ['Administración de Hotelería y Turismo','Administración y economía','E','S'],
            ['Administración Pública','Administración y economía','E','C'],
            ['Aeronáutica','Ingeniería y tecnología','R','I'],
            ['Agroindustria','Agropecuaria y medio ambiente','R','E'],
            ['Arqueología','Ciencias sociales y jurídicas','I','A'],
            ['Artes Musicales','Arte, diseño y arquitectura','A','S'],
            ['Bioingeniería','Ingeniería y tecnología','I','R'],
            ['Bioimagenología','Salud y bienestar','I','R'],
            ['Bibliotecología y Ciencias de la Información','Humanidades y educación','C','I'],
            ['Ciencias Ambientales','Ciencias naturales y exactas','I','S'],
            ['Ciencias Políticas','Ciencias sociales y jurídicas','E','I'],
            ['Comercio Exterior','Administración y economía','E','C'],
            ['Comercio Internacional','Administración y economía','E','C'],
            ['Diseño de Interiores','Arte, diseño y arquitectura','A','R'],
            ['Diseño Industrial','Arte, diseño y arquitectura','A','R'],
            ['Ecología','Ciencias naturales y exactas','I','S'],
            ['Educación Especial','Humanidades y educación','S','I'],
            ['Educación Parvularia','Humanidades y educación','S','A'],
            ['Fisioterapia y Kinesiología','Salud y bienestar','S','R'],
            ['Fonoaudiología','Salud y bienestar','S','I'],
            ['Ingeniería Aeronáutica','Ingeniería y tecnología','R','I'],
            ['Ingeniería Agroforestal','Agropecuaria y medio ambiente','R','I'],
            ['Ingeniería Agroindustrial','Agropecuaria y medio ambiente','R','E'],
            ['Ingeniería Agropecuaria','Agropecuaria y medio ambiente','R','I'],
            ['Ingeniería Autotrónica','Ingeniería y tecnología','R','I'],
            ['Ingeniería Biomédica','Ingeniería y tecnología','I','S'],
            ['Ingeniería Comercial','Administración y economía','E','I'],
            ['Ingeniería de Alimentos','Ingeniería y tecnología','I','R'],
            ['Ingeniería de Materiales','Ingeniería y tecnología','I','R'],
            ['Ingeniería de Petróleo y Gas Natural','Ingeniería y tecnología','R','I'],
            ['Ingeniería de Redes y Telecomunicaciones','Ingeniería y tecnología','I','R'],
            ['Ingeniería de Software','Ingeniería y tecnología','I','A'],
            ['Ingeniería de Sonido','Ingeniería y tecnología','A','R'],
            ['Ingeniería de Telecomunicaciones','Ingeniería y tecnología','I','R'],
            ['Ingeniería Electromecánica','Ingeniería y tecnología','R','I'],
            ['Ingeniería Financiera','Administración y economía','I','C'],
            ['Ingeniería Forestal','Agropecuaria y medio ambiente','R','I'],
            ['Ingeniería Geográfica','Ingeniería y tecnología','I','R'],
            ['Ingeniería Geológica','Ingeniería y tecnología','I','R'],
            ['Ingeniería Mecatrónica','Ingeniería y tecnología','I','R'],
            ['Ingeniería Metalúrgica','Ingeniería y tecnología','R','I'],
            ['Ingeniería Petroquímica','Ingeniería y tecnología','I','R'],
            ['Ingeniería Sanitaria y Ambiental','Ingeniería y tecnología','I','S'],
            ['Ingeniería Textil','Ingeniería y tecnología','R','A'],
            ['Kinesiología y Fisioterapia','Salud y bienestar','S','R'],
            ['Laboratorio Clínico','Salud y bienestar','I','C'],
            ['Lenguas Modernas y Filología','Humanidades y educación','A','I'],
            ['Marketing y Publicidad','Administración y economía','E','A'],
            ['Música','Arte, diseño y arquitectura','A','S'],
            ['Periodismo','Ciencias sociales y jurídicas','A','S'],
            ['Planificación Territorial','Ciencias sociales y jurídicas','I','E'],
            ['Producción Audiovisual','Arte, diseño y arquitectura','A','E'],
            ['Psicopedagogía','Humanidades y educación','S','I'],
            ['Publicidad','Arte, diseño y arquitectura','A','E'],
            ['Relaciones Internacionales','Ciencias sociales y jurídicas','E','S'],
            ['Relaciones Públicas','Ciencias sociales y jurídicas','E','S'],
            ['Teatro','Arte, diseño y arquitectura','A','S'],
            ['Tecnología Médica','Salud y bienestar','I','R'],
            ['Teología','Humanidades y educación','I','S'],
            ['Turismo y Hotelería','Administración y economía','E','S'],
            ['Zootecnia','Agropecuaria y medio ambiente','R','I'],
        ];

        $technical = [
            ['Acuicultura','Agropecuaria y medio ambiente','R','I'],
            ['Administración Aduanera','Administración y economía','C','E'],
            ['Administración Financiera','Administración y economía','C','E'],
            ['Administración Hotelera','Administración y economía','E','S'],
            ['Administración Rural','Agropecuaria y medio ambiente','E','R'],
            ['Agricultura Ecológica','Agropecuaria y medio ambiente','R','I'],
            ['Agroecología','Agropecuaria y medio ambiente','R','I'],
            ['Agroindustria Rural','Agropecuaria y medio ambiente','R','E'],
            ['Apicultura','Agropecuaria y medio ambiente','R','I'],
            ['Artes Gráficas','Arte, diseño y arquitectura','A','R'],
            ['Artes Plásticas y Visuales','Arte, diseño y arquitectura','A','R'],
            ['Automatización Industrial','Industria y mecánica','I','R'],
            ['Automatización y Robótica','Industria y mecánica','I','R'],
            ['Autotrónica','Industria y mecánica','R','I'],
            ['Belleza Integral','Gastronomía y servicios','A','S'],
            ['Biomédica','Salud y bienestar','I','R'],
            ['Caficultura Empresarial','Agropecuaria y medio ambiente','R','E'],
            ['Comercio Exterior y Aduanas','Administración y economía','E','C'],
            ['Confección Industrial','Industria y mecánica','R','A'],
            ['Cosmetología y Estética','Gastronomía y servicios','A','S'],
            ['Decoración de Interiores','Arte, diseño y arquitectura','A','R'],
            ['Desarrollo de Aplicaciones Móviles','Tecnología e informática','I','A'],
            ['Diseño de Modas','Arte, diseño y arquitectura','A','E'],
            ['Diseño Multimedia','Arte, diseño y arquitectura','A','I'],
            ['Ecoturismo Comunitario','Agropecuaria y medio ambiente','S','E'],
            ['Electricidad Industrial','Industria y mecánica','R','I'],
            ['Electromecánica Industrial','Industria y mecánica','R','I'],
            ['Electrónica','Industria y mecánica','I','R'],
            ['Electrónica Automotriz','Industria y mecánica','R','I'],
            ['Electrónica y Telecomunicaciones','Industria y mecánica','I','R'],
            ['Electrotecnia Industrial','Industria y mecánica','R','I'],
            ['Estructuras Metálicas','Construcción y territorio','R','C'],
            ['Forestal','Agropecuaria y medio ambiente','R','I'],
            ['Formación Parvularia','Humanidades y educación','S','A'],
            ['Gestión de Agua y Riego','Agropecuaria y medio ambiente','R','I'],
            ['Gestión de Recursos Hídricos','Agropecuaria y medio ambiente','I','R'],
            ['Gestión Municipal','Administración y economía','E','C'],
            ['Hotelería','Gastronomía y servicios','E','S'],
            ['Industria de Alimentos','Gastronomía y servicios','R','I'],
            ['Industria de la Madera','Industria y mecánica','R','A'],
            ['Industria Textil y Confección','Industria y mecánica','R','A'],
            ['Laboratorio Dental','Salud y bienestar','R','C'],
            ['Maquinaria Pesada','Industria y mecánica','R','I'],
            ['Maquinaria Pesada y Agrícola','Industria y mecánica','R','I'],
            ['Mecánica Industrial','Industria y mecánica','R','I'],
            ['Metalurgia, Siderurgia y Fundición','Industria y mecánica','R','I'],
            ['Música Boliviana','Arte, diseño y arquitectura','A','S'],
            ['Optometría','Salud y bienestar','I','S'],
            ['Panadería y Pastelería','Gastronomía y servicios','R','A'],
            ['Parvularia','Humanidades y educación','S','A'],
            ['Perito en Banca','Administración y economía','C','E'],
            ['Piscicultura','Agropecuaria y medio ambiente','R','I'],
            ['Programación de Sistemas','Tecnología e informática','I','R'],
            ['Química Industrial','Industria y mecánica','I','R'],
            ['Rayos X','Salud y bienestar','I','R'],
            ['Redes y Sistemas de Comunicación','Tecnología e informática','I','R'],
            ['Secretariado Administrativo','Comunicación y asistencia ejecutiva','C','S'],
            ['Soldadura Industrial','Industria y mecánica','R','C'],
            ['Telecomunicaciones','Tecnología e informática','I','R'],
            ['Veterinaria y Zootecnia','Agropecuaria y medio ambiente','R','I'],
            ['Viticultura y Enología','Agropecuaria y medio ambiente','R','I'],
        ];

        foreach ($university as $item) $this->store($item, 'Licenciatura', 2016, self::UNIVERSITY_URL, 'Guía de Universidades del Estado Plurinacional de Bolivia');
        foreach ($technical as $item) $this->store($item, 'Técnico Superior / Técnico Medio', 2024, self::TECHNICAL_URL, 'Guía de Institutos Técnicos, Tecnológicos y Artísticos de Bolivia');

        $this->mergeEquivalentNames();
        $this->backfillInitialSources();
    }

    private function store(array $item, string $level, int $year, string $url, string $sourceName): void
    {
        [$name, $areaName, $primary, $secondary] = $item;
        $area = AcademicArea::where('name', $areaName)->firstOrFail();
        $career = Career::where('slug', Str::slug($name))->first();

        if (!$career) {
            $career = Career::create([
                'academic_area_id' => $area->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'degree_level' => $level,
                'is_traditional' => false,
                'riasec_primary' => $primary,
                'riasec_secondary' => $secondary,
                'summary' => "Formación profesional en {$name}, incluida en la oferta académica reconocida en Bolivia.",
                'source_url' => $url,
                'is_active' => true,
            ]);
        } elseif (!str_contains($career->degree_level, $level)) {
            $career->update(['degree_level' => $career->degree_level.' / '.$level]);
        }

        CareerSource::updateOrCreate(
            ['career_id' => $career->id, 'source_url' => $url],
            ['source_name' => $sourceName, 'source_year' => $year, 'notes' => "La guía registra {$name} con nivel {$level}.", 'checked_at' => now()]
        );
    }

    private function mergeEquivalentNames(): void
    {
        $canonical = Career::where('slug', 'fisioterapia-y-kinesiologia')->first();
        $variant = Career::where('slug', 'kinesiologia-y-fisioterapia')->first();

        if ($canonical && $variant) {
            $aliases = array_values(array_unique(array_merge($canonical->alternative_names ?? [], ['Kinesiología y Fisioterapia'])));
            $canonical->update(['alternative_names' => $aliases]);
            $variant->update(['is_active' => false]);
        }
    }

    private function backfillInitialSources(): void
    {
        Career::query()->whereDoesntHave('sources')->whereNotNull('source_url')->each(function (Career $career) {
            $host = parse_url($career->source_url, PHP_URL_HOST) ?: 'Fuente institucional';
            $name = match (true) {
                str_contains($host, 'itsa.edu.bo') => 'Instituto Tecnológico Sacaba',
                str_contains($host, 'umss.edu.bo') => 'Universidad Mayor de San Simón',
                str_contains($host, 'umsa.bo') => 'Universidad Mayor de San Andrés',
                default => 'Fuente académica oficial',
            };

            CareerSource::create([
                'career_id' => $career->id,
                'source_name' => $name,
                'source_url' => $career->source_url,
                'source_year' => 2026,
                'notes' => 'Fuente institucional utilizada para el catálogo inicial.',
                'checked_at' => now(),
            ]);
        });
    }
}
