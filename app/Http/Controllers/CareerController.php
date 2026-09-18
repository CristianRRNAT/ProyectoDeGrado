<?php

namespace App\Http\Controllers;

use App\Models\AcademicArea;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'exists:academic_areas,slug'],
            'type' => ['nullable', 'string', 'in:traditional,nontraditional'],
        ]);

        $filters['type'] ??= 'traditional';

        $careers = Career::query()
            ->with('academicArea')
            ->withCount(['institutions' => fn ($query) => $query->where('institution_career.is_active', true)])
            ->where('is_active', true)
            ->when(($filters['type'] ?? null) === 'traditional', fn ($query) => $query->whereDoesntHave('academicArea', fn ($area) => $area->where('slug', 'carreras-no-tradicionales')))
            ->when(($filters['type'] ?? null) === 'nontraditional', fn ($query) => $query->whereHas('academicArea', fn ($area) => $area->where('slug', 'carreras-no-tradicionales')))
            ->when($filters['q'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('alternative_names', 'like', "%{$search}%")
                        ->when(preg_match('/maestr|profesor|docent/i', $search), fn ($query) => $query->orWhere('name', 'like', '%Formación de Maestros%'));
                });
            })
            ->when($filters['area'] ?? null, fn ($query, $area) => $query->whereHas('academicArea', fn ($query) => $query->where('slug', $area)))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('careers.index', [
            'careers' => $careers,
            'areas' => AcademicArea::where('is_active', true)
                ->where('slug', '!=', 'carreras-no-tradicionales')
                ->whereHas('careers', fn ($query) => $query->where('is_active', true))
                ->orderBy('name')
                ->get(),
            'filters' => $filters,
        ]);
    }

    public function show(Career $career): View
    {
        abort_unless($career->is_active, 404);
        $career->loadCount(['institutions' => fn ($query) => $query->where('institution_career.is_active', true)]);
        $career->load(['academicArea', 'sources' => fn ($query) => $query->orderByDesc('source_year'), 'institutions' => fn ($query) => $query->where('institution_career.is_active', true)->with('department')->orderBy('name')->limit(5)]);

        $related = Career::query()
            ->where('is_active', true)
            ->where('academic_area_id', $career->academic_area_id)
            ->whereKeyNot($career->id)
            ->orderBy('name')
            ->limit(3)
            ->get();

        $careerVideos = $this->careerVideos($career);
        $careerSpecializations = $career->specializations ?: $this->fallbackSpecializations($career);
        $career->setAttribute('specializations', $careerSpecializations);
        $allCareerInstitutions = $career->institutions()
            ->where('institution_career.is_active', true)
            ->with('department')
            ->orderBy('name')
            ->get()
            ->map(fn ($institution) => [
                'name' => $institution->name,
                'url' => route('institutions.show', $institution),
                'location' => collect([$institution->city, $institution->department?->name])->filter()->join(', '),
                'level' => $institution->pivot->degree_level ?? $career->degree_level,
                'modality' => $institution->pivot->modality ?? 'Consultar',
            ])
            ->values();

        return view('careers.show', compact('career', 'related', 'careerVideos', 'careerSpecializations', 'allCareerInstitutions'));
    }

    private function fallbackSpecializations(Career $career): array
    {
        $text = mb_strtolower($career->name);
        $area = $career->academicArea?->slug ?? '';

        if (str_contains($text, 'actividad física') || str_contains($text, 'deporte')) {
            return $this->specialtyCards([
                ['Educación física', 'Enseñanza del movimiento, hábitos saludables y actividad corporal en contextos educativos.'],
                ['Ciencias del deporte', 'Estudio del rendimiento, entrenamiento, fisiología y evaluación de la actividad física.'],
                ['Gestión deportiva', 'Administración de clubes, instalaciones, eventos y proyectos deportivos.'],
                ['Recreación y actividad física', 'Diseño de programas recreativos y de bienestar para distintos grupos de población.'],
            ]);
        }

        $groups = [
            'salud' => [
                ['Atención especializada', 'Prevención, evaluación y atención de necesidades relacionadas con la salud.'],
                ['Salud comunitaria', 'Promoción de hábitos saludables y trabajo con familias y comunidades.'],
                ['Gestión sanitaria', 'Organización y calidad de servicios y programas de salud.'],
                ['Investigación', 'Análisis de evidencia para mejorar procedimientos y resultados profesionales.'],
            ],
            'tecnologia' => [
                ['Desarrollo y soluciones', 'Creación de herramientas, sistemas y soluciones tecnológicas.'],
                ['Datos e innovación', 'Análisis de información, automatización y mejora de procesos.'],
                ['Infraestructura y seguridad', 'Administración y protección de equipos, redes y servicios.'],
                ['Gestión de proyectos', 'Planificación de recursos, calidad y transformación tecnológica.'],
            ],
            'ingenieria' => [
                ['Diseño y proyectos', 'Planificación y desarrollo técnico de obras, productos o sistemas.'],
                ['Operaciones y producción', 'Organización y mejora de procesos, recursos, equipos y calidad.'],
                ['Mantenimiento y seguridad', 'Prevención de fallas y operación segura de instalaciones y maquinaria.'],
                ['Gestión técnica', 'Administración de costos, normativa y ejecución de proyectos.'],
            ],
            'economia' => [
                ['Gestión y estrategia', 'Planificación de recursos, procesos y decisiones organizacionales.'],
                ['Finanzas y control', 'Administración de presupuestos, costos e información económica.'],
                ['Marketing y negocios', 'Estudio de mercados, clientes, ventas y oportunidades comerciales.'],
                ['Emprendimiento', 'Creación y desarrollo de productos, servicios y modelos de negocio.'],
            ],
            'educacion' => [
                ['Docencia', 'Planificación de experiencias de aprendizaje según el área y nivel educativo.'],
                ['Orientación educativa', 'Acompañamiento del aprendizaje, la convivencia y el desarrollo integral.'],
                ['Tecnología educativa', 'Uso de recursos digitales para fortalecer la enseñanza.'],
                ['Gestión e investigación', 'Evaluación y estudio de proyectos y problemas educativos.'],
            ],
            'arte' => [
                ['Creación e interpretación', 'Desarrollo de propuestas expresivas mediante técnicas de la disciplina.'],
                ['Producción', 'Planificación y realización de obras, contenidos o productos creativos.'],
                ['Gestión cultural', 'Organización de proyectos, espacios y emprendimientos culturales.'],
                ['Educación artística', 'Enseñanza y mediación de procesos creativos para diferentes públicos.'],
            ],
        ];

        $key = match (true) {
            str_contains($area, 'salud') => 'salud',
            str_contains($area, 'tecnolog') => 'tecnologia',
            str_contains($area, 'ingenier') => 'ingenieria',
            str_contains($area, 'econom') || str_contains($area, 'administr') => 'economia',
            str_contains($area, 'educ') => 'educacion',
            str_contains($area, 'arte') || str_contains($area, 'no-tradicional') => 'arte',
            default => null,
        };

        return $this->specialtyCards($groups[$key] ?? [
            ['Práctica profesional', 'Aplicación de conocimientos y técnicas en situaciones reales.'],
            ['Gestión de proyectos', 'Planificación de recursos, actividades, tiempos y resultados.'],
            ['Calidad e innovación', 'Mejora de procesos y desarrollo de soluciones responsables.'],
            ['Emprendimiento', 'Creación de servicios o iniciativas vinculadas con esta formación.'],
        ]);
    }

    private function specialtyCards(array $cards): array
    {
        return array_map(fn (array $card) => [
            'name' => $card[0],
            'description' => $card[1],
        ], $cards);
    }

    private function careerVideos(Career $career): array
    {
        $videoOverrides = [
            'danza' => [
                [
                    'title' => 'Nunca dejes de bailar — Fama Estudio de Danza Bolivia',
                    'description' => 'Una referencia boliviana para conocer de cerca la formación y pasión por la danza.',
                    'youtube_id' => 'CNUJaI0sxgE',
                    'url' => 'https://www.youtube.com/watch?v=CNUJaI0sxgE',
                ],
                [
                    'title' => 'Cómo ser un bailarín profesional y bailar más limpio',
                    'description' => 'Consejos prácticos para principiantes que desean mejorar su técnica y avanzar profesionalmente.',
                    'youtube_id' => 'PZdcW-Uzp80',
                    'url' => 'https://www.youtube.com/watch?v=PZdcW-Uzp80',
                ],
            ],
        ];

        if (isset($videoOverrides[$career->slug])) {
            return $videoOverrides[$career->slug];
        }

        return Cache::remember('career-videos:'.$career->slug, now()->addDays(7), function () use ($career): array {
            $definitions = [
                ['title' => 'Conoce la carrera de '.$career->name.' en Bolivia', 'description' => 'Formación, universidades y realidad profesional en el país.', 'query' => $career->name.' carrera universidades Bolivia'],
                ['title' => 'Experiencias y consejos para estudiar '.$career->name, 'description' => 'Una referencia adicional para conocer mejor esta elección profesional.', 'query' => 'estudiar '.$career->name.' experiencias consejos'],
            ];
            $usedIds = [];

            foreach ($definitions as &$video) {
                $video['youtube_id'] = null;
                try {
                    $response = Http::withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0 Safari/537.36')
                        ->withHeaders(['Accept-Language' => 'es-BO,es;q=0.9', 'Cookie' => 'CONSENT=YES+cb'])
                        ->timeout(10)
                        ->get('https://www.youtube.com/results', ['search_query' => $video['query'], 'hl' => 'es']);

                    if ($response->successful() && preg_match_all('/\x22videoId\x22:\x22([A-Za-z0-9_-]{11})\x22/', $response->body(), $matches)) {
                        $video['youtube_id'] = collect($matches[1])->unique()->first(fn (string $id) => ! in_array($id, $usedIds, true));
                    }
                } catch (\Throwable) {
                    // La tarjeta seguirá ofreciendo la búsqueda de YouTube si el servicio no está disponible.
                }

                if ($video['youtube_id']) {
                    $usedIds[] = $video['youtube_id'];
                    $video['url'] = 'https://www.youtube.com/watch?v='.$video['youtube_id'];
                } else {
                    $video['url'] = 'https://www.youtube.com/results?search_query='.rawurlencode($video['query']);
                }
            }
            unset($video);

            return $definitions;
        });
    }
}
