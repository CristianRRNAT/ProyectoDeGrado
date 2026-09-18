<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Institution;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'exists:departments,slug'],
            'payment' => ['nullable', 'string', 'in:Gratuita,De pago,Mixta'],
        ]);

        $institutions = Institution::query()->with('department')
            ->withCount(['careers' => fn ($query) => $query->where('institution_career.is_active', true)])
            ->where('is_active', true)
            ->when($filters['q'] ?? null, fn ($query, $search) => $query->where(fn ($query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('acronym', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('campuses', 'like', "%{$search}%")))
            ->when($filters['department'] ?? null, fn ($query, $department) => $query->where(fn ($query) => $query
                ->whereHas('department', fn ($query) => $query->where('slug', $department))
                ->orWhere(function ($query) use ($department) {
                    if ($query->getConnection()->getDriverName() === 'sqlite') {
                        $query->whereRaw("exists (select 1 from json_each(institutions.campuses) as campus where json_extract(campus.value, '$.department_slug') = ?)", [$department]);
                    } else {
                        $query->whereJsonContains('campuses', ['department_slug' => $department]);
                    }
                })))
            ->when($filters['payment'] ?? null, fn ($query, $payment) => $query->where('payment_type', $payment))
            ->orderBy('name')->paginate(auth()->check() ? 12 : 24)->withQueryString();

        $directoryMapInstitutions = Institution::query()
            ->with('department:id,name,slug')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'department_id', 'name', 'slug', 'city', 'address', 'latitude', 'longitude', 'campuses'])
            ->flatMap(function (Institution $institution) {
                $locations = collect([[
                    'institution' => $institution->name,
                    'slug' => $institution->slug,
                    'label' => $institution->city,
                    'department' => $institution->department->name,
                    'department_slug' => $institution->department->slug,
                    'city' => $institution->city,
                    'address' => $institution->address,
                    'latitude' => $institution->latitude ? (float) $institution->latitude : null,
                    'longitude' => $institution->longitude ? (float) $institution->longitude : null,
                ]]);

                return $locations->merge(collect($institution->campuses ?? [])->map(fn ($campus) => [
                    'institution' => $institution->name,
                    'slug' => $institution->slug,
                    'label' => $campus['name'] ?? ($campus['city'] ?? 'Sede'),
                    'department' => $campus['department'] ?? $institution->department->name,
                    'department_slug' => $campus['department_slug'] ?? str($campus['department'] ?? $institution->department->name)->slug()->toString(),
                    'city' => $campus['city'] ?? '',
                    'address' => $campus['address'] ?? '',
                    'latitude' => isset($campus['latitude']) ? (float) $campus['latitude'] : null,
                    'longitude' => isset($campus['longitude']) ? (float) $campus['longitude'] : null,
                ]));
            })->values();

        return view(auth()->check() ? 'institutions.index' : 'institutions.guest-index', [
            'institutions' => $institutions,
            'departments' => Department::where('is_active', true)->orderBy('name')->get(),
            'filters' => $filters,
            'directoryMapInstitutions' => $directoryMapInstitutions,
        ]);
    }

    public function show(Institution $institution): View
    {
        abort_unless($institution->is_active, 404);
        $institution->load([
            'department',
            'units' => fn ($query) => $query->where('is_active', true),
            'careers' => fn ($query) => $query->where('institution_career.is_active', true)->with('academicArea')->orderBy('name'),
        ]);

        $careersByUnit = $institution->careers->groupBy(fn ($career) => $career->pivot->institution_unit_id ?: 'direct');
        $locationCount = 1 + count($institution->campuses ?? []);
        $hasMultipleLocations = $locationCount > 1;
        if ($hasMultipleLocations) {
            // La portada debe describir a la institución completa, sin presentar
            // la ubicación heredada del registro principal como sede principal.
            $institution->description = $institution->name.' cuenta con '.$locationCount
                .' sedes registradas en Bolivia.';
        }
        $locationDepartments = collect([$institution->department->name])
            ->merge(collect($institution->campuses ?? [])->pluck('department'))
            ->filter()->unique()->values();

        $primaryQuery = $institution->latitude && $institution->longitude
            ? $institution->latitude.','.$institution->longitude
            : $institution->address.', '.$institution->city.', '.$institution->department->name.', Bolivia';

        $mapLocations = collect([[
            'name' => 'Sede '.$institution->city,
            'address' => $primaryQuery,
            'display_address' => $institution->address,
            'detail' => $hasMultipleLocations ? 'Ubicación registrada' : 'Sede de la institución',
            'city' => $institution->city,
            'department' => $institution->department->name,
            'latitude' => $institution->latitude,
            'longitude' => $institution->longitude,
        ]])->merge(collect($institution->campuses ?? [])->map(fn ($campus) => [
            'name' => $campus['name'],
            'address' => ($campus['address'] ?? $campus['name']).', '.($campus['city'] ?? '').', '.($campus['department'] ?? '').', Bolivia',
            'display_address' => $campus['address'] ?? $campus['name'],
            'detail' => implode(', ', $campus['programs'] ?? []),
            'city' => $campus['city'] ?? '',
            'department' => $campus['department'] ?? '',
            'latitude' => $campus['latitude'] ?? null,
            'longitude' => $campus['longitude'] ?? null,
        ]))->unique('address')->values();

        $institutionRouteData = [
            'enabled' => true,
            'institution' => $institution->name,
            'locations' => $mapLocations->map(fn (array $location) => [
                'name' => $location['name'],
                'city' => $location['city'],
                'department' => $location['department'],
                'destination' => $location['latitude'] && $location['longitude']
                    ? $location['latitude'].','.$location['longitude']
                    : $location['address'],
            ])->values()->all(),
        ];
        $institutionProfile = $this->institutionProfile($institution);
        $institutionComments = Comment::query()
            ->with('user')
            ->withCount('likedBy')
            ->where('institution_id', $institution->id)
            ->where('status', 'approved')
            ->latest('reviewed_at')
            ->get();
        $likedCommentIds = DB::table('comment_likes')
            ->where('user_id', auth()->id())
            ->whereIn('comment_id', $institutionComments->pluck('id'))
            ->pluck('comment_id');

        return view('institutions.show', compact(
            'institution',
            'careersByUnit',
            'locationCount',
            'hasMultipleLocations',
            'locationDepartments',
            'primaryQuery',
            'mapLocations',
            'institutionRouteData',
            'institutionProfile',
            'institutionComments',
            'likedCommentIds',
        ));
    }

    private function institutionProfile(Institution $institution): array
    {
        $slug = $institution->slug;
        $type = mb_strtolower($institution->institution_type);
        $scheduleText = mb_strtolower($institution->schedule_notes.' '.$institution->careers->pluck('pivot.schedule')->filter()->join(' '));
        $hasMorning = str_contains($scheduleText, 'mañana') || str_contains($scheduleText, 'diurno');
        $hasNight = str_contains($scheduleText, 'noche') || str_contains($scheduleText, 'nocturno');
        $schedule = $hasMorning && $hasNight ? 'Mañana y noche' : ($hasMorning ? 'Mañana' : ($hasNight ? 'Noche' : 'Consultar con la institución'));

        $levels = $institution->careers->pluck('pivot.degree_level')
            ->merge($institution->careers->pluck('degree_level'))
            ->filter()->unique()->values();
        $titles = $levels->isNotEmpty()
            ? 'La oferta registrada comprende '.mb_strtolower($levels->join(', ', ' y ')).'. El nombre exacto del título depende de cada programa.'
            : 'El nivel y el título deben confirmarse en la oferta académica y resolución vigente.';

        $admission = match (true) {
            str_contains($slug, 'universidad-mayor-de-san-simon') =>
                'La UMSS aplica examen de ingreso, curso preuniversitario y modalidades especiales. También contempla admisión para mejores bachilleres habilitados; algunas carreras exigen pruebas adicionales y el área de salud tiene reglas propias.',
            str_contains($slug, 'formacion-de-maestras') || str_contains($type, 'maestro') =>
                'El ingreso se realiza mediante la convocatoria nacional para Escuelas Superiores de Formación de Maestras y Maestros, con requisitos documentales y la evaluación definida para cada gestión.',
            str_contains($slug, 'polici') || str_contains($slug, 'fatescipol') =>
                'El ingreso depende de convocatoria y cupos e incluye revisión documental y evaluaciones académicas, médicas, psicológicas y físicas establecidas por la Universidad Policial.',
            str_contains($slug, 'militar') || str_contains($slug, 'ejercito') || str_contains($slug, 'aviacion') || str_contains($slug, 'naval') =>
                'El ingreso depende de convocatoria y cupos e incluye requisitos documentales, académicos, médicos, psicológicos y físicos establecidos por la institución militar.',
            str_contains($type, 'artíst') || str_contains($type, 'artist') || str_contains($slug, 'musica') || str_contains($slug, 'bellas-artes') =>
                'La admisión suele considerar documentos de bachiller y una prueba de aptitud, audición o evaluación práctica, según la especialidad y la convocatoria.',
            str_contains($type, 'universidad') && in_array(mb_strtolower($institution->ownership ?? ''), ['pública', 'publica', 'fiscal'], true) =>
                'La admisión puede realizarse mediante examen, curso preuniversitario o modalidades especiales y directas definidas por cada facultad. Debe revisarse la convocatoria vigente de la carrera.',
            str_contains($type, 'universidad') =>
                'Generalmente requiere inscripción, título o diploma de bachiller y documentos personales; algunas carreras incorporan entrevista, nivelación o evaluación. Debe confirmarse en la convocatoria vigente.',
            default =>
                'El ingreso se realiza mediante convocatoria e inscripción con documentos de bachiller. Si la demanda supera los cupos, la institución puede aplicar evaluación o criterios de selección; debe confirmarse cada gestión.',
        };

        $graduation = str_contains($slug, 'universidad-mayor-de-san-simon')
            ? $titles.' En la UMSS las modalidades incluyen tesis, proyecto de grado, trabajo dirigido, internado en salud, excelencia académica y otras opciones reguladas según nivel y carrera.'
            : $titles.' La modalidad final puede incluir proyecto, trabajo dirigido, examen, práctica, tesina, tesis u otra opción autorizada por la institución y el nivel académico.';

        return [
            'verification' => $institution->is_verified
                ? 'Institución contrastada con registros y fuentes oficiales de educación superior. La autorización específica de cada carrera debe revisarse en su resolución y oferta vigente.'
                : 'La información institucional está en proceso de verificación documental.',
            'verification_label' => $institution->is_verified ? 'Verificada por el Ministerio de Educación' : 'Verificación pendiente',
            'schedule' => $schedule,
            'admission' => $admission,
            'graduation' => $graduation,
        ];
    }
}
