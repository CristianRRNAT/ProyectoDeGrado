<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\VocationalTestResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class VocationalTestController extends Controller
{
    public function basic(): View
    {
        $questions = [
            ['type' => 'R', 'text' => 'Disfruto construir, reparar o armar objetos con mis propias manos.'],
            ['type' => 'I', 'text' => 'Me gusta investigar por qué ocurren las cosas y encontrar explicaciones.'],
            ['type' => 'A', 'text' => 'Me entusiasma expresar ideas mediante dibujos, historias, música o diseño.'],
            ['type' => 'S', 'text' => 'Me siento bien cuando escucho, enseño o ayudo a otras personas.'],
            ['type' => 'E', 'text' => 'Disfruto proponer proyectos y motivar a otros para realizarlos.'],
            ['type' => 'C', 'text' => 'Me agrada ordenar información y trabajar siguiendo un proceso claro.'],
            ['type' => 'R', 'text' => 'Prefiero aprender haciendo pruebas prácticas en lugar de solo leer teoría.'],
            ['type' => 'I', 'text' => 'Los problemas de lógica, ciencia o tecnología despiertan mi curiosidad.'],
            ['type' => 'A', 'text' => 'Suelo imaginar maneras nuevas y originales de presentar una idea.'],
            ['type' => 'S', 'text' => 'Me interesa comprender cómo se sienten y piensan las personas.'],
            ['type' => 'E', 'text' => 'Me resulta natural tomar decisiones y asumir responsabilidades en un grupo.'],
            ['type' => 'C', 'text' => 'Presto atención a los detalles y procuro que los datos sean correctos.'],
            ['type' => 'R', 'text' => 'Me gustaría trabajar con herramientas, equipos, vehículos o espacios naturales.'],
            ['type' => 'I', 'text' => 'Antes de aceptar una respuesta, prefiero analizar evidencias y posibilidades.'],
            ['type' => 'A', 'text' => 'Valoro los ambientes donde puedo experimentar sin una única respuesta correcta.'],
            ['type' => 'S', 'text' => 'Me imagino trabajando en algo que mejore la vida de mi comunidad.'],
            ['type' => 'E', 'text' => 'Me atrae negociar, emprender o convertir una idea en una oportunidad.'],
            ['type' => 'C', 'text' => 'Disfruto planificar actividades, clasificar recursos y cumplir plazos.'],
        ];

        $profiles = [
            'R' => ['name' => 'Realista', 'phrase' => 'Crear soluciones con acción y precisión', 'description' => 'Aprendes haciendo y disfrutas transformar ideas en resultados concretos. Sueles conectar con entornos prácticos, técnicos y dinámicos.', 'strengths' => ['Practicidad', 'Constancia', 'Habilidad técnica'], 'careers' => ['Mecánica Automotriz', 'Construcción Civil', 'Topografía y Geodesia', 'Electromecánica']],
            'I' => ['name' => 'Investigador', 'phrase' => 'Comprender, analizar y descubrir', 'description' => 'Tu curiosidad te impulsa a estudiar problemas, buscar evidencias y comprender cómo funcionan las cosas antes de proponer soluciones.', 'strengths' => ['Análisis', 'Curiosidad', 'Pensamiento lógico'], 'careers' => ['Sistemas Informáticos', 'Medicina', 'Ingeniería', 'Biotecnología']],
            'A' => ['name' => 'Artístico', 'phrase' => 'Imaginar y comunicar nuevas posibilidades', 'description' => 'Valoras la libertad para crear, expresar y experimentar. Encuentras posibilidades originales donde otras personas ven caminos conocidos.', 'strengths' => ['Creatividad', 'Expresión', 'Innovación'], 'careers' => ['Diseño Gráfico', 'Arquitectura', 'Comunicación Social', 'Producción Audiovisual']],
            'S' => ['name' => 'Social', 'phrase' => 'Acompañar, enseñar y generar bienestar', 'description' => 'Te moviliza comprender a las personas y contribuir a su desarrollo. La comunicación y el propósito colectivo son importantes para ti.', 'strengths' => ['Empatía', 'Comunicación', 'Cooperación'], 'careers' => ['Psicología', 'Educación', 'Enfermería', 'Trabajo Social']],
            'E' => ['name' => 'Emprendedor', 'phrase' => 'Liderar ideas y convertirlas en proyectos', 'description' => 'Disfrutas movilizar personas, tomar decisiones y detectar oportunidades. Te motivan los retos que requieren iniciativa y visión.', 'strengths' => ['Liderazgo', 'Persuasión', 'Iniciativa'], 'careers' => ['Administración de Empresas', 'Marketing', 'Derecho', 'Comercio Internacional']],
            'C' => ['name' => 'Convencional', 'phrase' => 'Organizar información con orden y precisión', 'description' => 'Te desenvuelves bien con estructuras claras, información detallada y objetivos definidos. Tu organización brinda estabilidad a los proyectos.', 'strengths' => ['Organización', 'Precisión', 'Responsabilidad'], 'careers' => ['Contaduría General', 'Finanzas', 'Secretariado Ejecutivo', 'Administración Pública']],
        ];

        return view('tests.basic', compact('questions', 'profiles'));
    }

    public function complete(Request $request): View
    {
        return view('tests.complete', [
            'questions' => config('vocational_test.questions'),
            'profiles' => config('vocational_test.profiles'),
            'user' => $request->user(),
        ]);
    }

    public function storeComplete(Request $request): RedirectResponse
    {
        $questions = config('vocational_test.questions');
        $validated = $request->validate([
            'answers' => ['required', 'array', 'size:'.count($questions)],
            'answers.*' => ['required', 'integer', 'between:0,3'],
        ], ['answers.size' => 'Debes responder las 30 preguntas antes de finalizar.']);

        $scores = array_fill_keys(['R', 'I', 'A', 'S', 'E', 'C'], 0);
        foreach ($questions as $index => $question) {
            $scores[$question['type']] += (int) $validated['answers'][$index];
        }

        $order = ['R' => 0, 'I' => 1, 'A' => 2, 'S' => 3, 'E' => 4, 'C' => 5];
        $ranking = array_keys($scores);
        usort($ranking, fn ($a, $b) => ($scores[$b] <=> $scores[$a]) ?: ($order[$a] <=> $order[$b]));
        $code = implode('', array_slice($ranking, 0, 3));
        $profiles = config('vocational_test.profiles');

        $careers = Career::query()->where('is_active', true)->whereNotNull('riasec_primary')->with('academicArea')->withCount('institutions')->get();
        $careers = $careers->sortByDesc(function (Career $career) use ($ranking, $scores, $questions, $validated) {
            $primaryPosition = array_search($career->riasec_primary, $ranking, true);
            $secondaryPosition = array_search($career->riasec_secondary, $ranking, true);
            $match = ($scores[$career->riasec_primary] ?? 0) * 5;
            $match += ($scores[$career->riasec_secondary] ?? 0) * 3;
            $match += $primaryPosition === false ? 0 : 18 - ($primaryPosition * 3);
            $match += $secondaryPosition === false ? 0 : 8 - $secondaryPosition;
            $careerText = str($career->name.' '.$career->summary.' '.$career->professional_field.' '.$career->academicArea?->name)->lower()->ascii()->toString();
            foreach ($questions as $index => $question) {
                $keywords = collect($question['keywords'] ?? [])->map(fn ($keyword) => str($keyword)->lower()->ascii()->toString());
                if ($keywords->contains(fn ($keyword) => str_contains($careerText, $keyword))) {
                    $match += (((int) $validated['answers'][$index]) - 1.5) * 4;
                }
            }
            return $match + min($career->institutions_count, 5) / 10;
        })->take(5)->values();

        $primary = $profiles[$ranking[0]];
        $secondary = $profiles[$ranking[1]];
        $third = $profiles[$ranking[2]];
        $interpretation = "Tu perfil destaca por {$primary['phrase']}. {$primary['description']} "
            ."También aparecen rasgos de {$secondary['name']} y {$third['name']}, lo que amplía tus posibilidades hacia ambientes donde puedas combinar "
            .strtolower($primary['strengths'][0]).', '.strtolower($secondary['strengths'][0]).' y '.strtolower($third['strengths'][0]).'.';

        $result = VocationalTestResult::create([
            'user_id' => $request->user()->id,
            'test_version' => config('vocational_test.version'),
            'profile_code' => $code,
            'answers' => array_values($validated['answers']),
            'scores' => $scores,
            'recommended_career_ids' => $careers->pluck('id')->all(),
            'interpretation' => $interpretation,
        ]);

        return redirect()->route('test.results.show', $result);
    }

    public function result(Request $request, VocationalTestResult $result): View
    {
        abort_unless($result->user_id === $request->user()->id, 403);
        $profiles = config('vocational_test.profiles');
        $careersById = Career::whereIn('id', $result->recommended_career_ids)->get()->keyBy('id');
        $careers = collect($result->recommended_career_ids)->map(fn ($id) => $careersById->get($id))->filter();

        return view('tests.result', compact('result', 'profiles', 'careers'));
    }

    public function downloadPdf(Request $request, VocationalTestResult $result): Response
    {
        abort_unless($result->user_id === $request->user()->id, 403);
        $profiles = config('vocational_test.profiles');
        $careersById = Career::whereIn('id', $result->recommended_career_ids)->get()->keyBy('id');
        $careers = collect($result->recommended_career_ids)->map(fn ($id) => $careersById->get($id))->filter();

        return Pdf::loadView('tests.pdf', compact('result', 'profiles', 'careers'))
            ->setPaper('a4')
            ->download('informe-vocacional-'.$result->id.'.pdf');
    }
}
