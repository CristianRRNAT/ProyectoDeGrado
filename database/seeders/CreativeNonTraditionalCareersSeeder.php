<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\CareerSource;
use Illuminate\Database\Seeder;

class CreativeNonTraditionalCareersSeeder extends Seeder
{
    public function run(): void
    {
        $area = AcademicArea::where('slug', 'carreras-no-tradicionales')->firstOrFail();

        $this->save($area->id, [
            'name' => 'Canto Profesional', 'slug' => 'canto-profesional',
            'alternative_names' => ['Cantante','Intérprete vocal','Vocalista','Artista musical','Cantante lírico','Cantante popular'],
            'duration_text' => 'Formación continua; cursos de meses a 4 años', 'reference_title' => 'Certificación, título artístico o trayectoria profesional',
            'summary' => 'Desarrolla la voz como instrumento artístico para interpretar música en vivo, grabaciones, producciones audiovisuales y proyectos culturales.',
            'description' => 'El canto profesional combina técnica vocal, interpretación, musicalidad, presencia escénica y cuidado de la voz. No depende únicamente de una voz agradable: exige práctica constante, repertorio, criterio artístico y capacidad para trabajar con músicos, productores y audiencias.',
            'study_focus' => 'Respiración, apoyo y resonancia, afinación, ritmo, dicción, interpretación, entrenamiento auditivo, repertorio, expresión corporal, micrófono, grabación, salud vocal, derechos musicales y gestión artística.',
            'specializations' => $this->items([
                ['Canto popular','Interpretación de géneros contemporáneos y tradicionales, identidad vocal y escenario.','bi-mic'],
                ['Canto lírico y académico','Técnica para repertorio clásico, ópera, coro y teatro musical.','bi-music-note'],
                ['Música boliviana y canto tradicional','Interpretación y difusión responsable de repertorios e identidades culturales.','bi-music-note-beamed'],
                ['Canto para estudio y sesión','Grabación por encargo, coros, jingles y colaboración con productores.','bi-vinyl'],
                ['Docencia y entrenamiento vocal','Enseñanza dentro del nivel de preparación y competencias adquiridas.','bi-person-video3'],
            ]),
            'learning_paths' => $this->paths('Técnica vocal, teoría musical, interpretación, escenario, grabación y gestión de carrera.', 'Especialización en técnica vocal, coro, repertorio popular, canto lírico o grabación.', 'Mejora de la voz, participación en agrupaciones o disfrute personal de la música.'),
            'professional_field' => 'Agrupaciones, coros, presentaciones, estudios de grabación, teatro musical, publicidad, eventos, instituciones culturales, docencia habilitada y proyectos propios.',
            'economic_scope' => 'Los ingresos suelen combinar presentaciones, sesiones, regalías, clases y contenido digital; pueden ser irregulares y dependen de preparación, audiencia, reputación y gestión de derechos.',
            'social_scope' => 'Fortalece expresión, identidad y memoria cultural; requiere cuidado de la salud vocal y respeto por la autoría.',
            'international_scope' => 'Las plataformas y colaboraciones permiten alcanzar públicos internacionales desde Bolivia. La proyección depende de técnica, repertorio, idioma, producción, derechos y representación.',
            'icon' => 'bi-mic-fill', 'riasec_primary' => 'A', 'riasec_secondary' => 'E',
            'source_url' => 'https://www.bls.gov/ooh/entertainment-and-sports/musicians-and-singers.htm',
            'source_name' => 'U.S. BLS — músicos y cantantes',
        ]);

        $this->save($area->id, [
            'name' => 'Diseño y Creación de Moda', 'slug' => 'diseno-y-creacion-de-moda',
            'alternative_names' => ['Diseñador de moda','Diseñadora de moda','Diseño de indumentaria','Diseño textil','Confección de prendas','Estilismo de moda'],
            'duration_text' => 'Cursos de meses a 3–4 años', 'reference_title' => 'Certificación, Técnico Superior o licenciatura según institución',
            'summary' => 'Crea prendas, accesorios y propuestas de indumentaria combinando identidad estética, conocimientos textiles, patronaje, confección y comprensión del mercado.',
            'description' => 'El diseño de moda transforma una idea en una colección o producto que puede fabricarse y utilizarse. Requiere creatividad, dibujo, investigación, materiales, patronaje, confección, pruebas, costos y comunicación visual. Puede integrar técnicas artesanales bolivianas respetando su autoría y contexto.',
            'study_focus' => 'Historia de moda, dibujo, color, textiles, patronaje, corte, confección, ilustración digital, desarrollo de colección, producción, costos, marca, sostenibilidad y propiedad intelectual.',
            'specializations' => $this->items([
                ['Diseño de indumentaria','Prendas casuales, formales, deportivas, escénicas o especializadas.','bi-person-standing-dress'],
                ['Patronaje y confección','Moldes, corte, ensamblaje, acabados, ajuste y control de calidad.','bi-scissors'],
                ['Diseño textil y superficies','Estampados, bordados, tejidos, color y materiales.','bi-grid-3x3-gap'],
                ['Accesorios y complementos','Bolsos, sombreros, joyería de moda, calzado y otros productos.','bi-handbag'],
                ['Styling y dirección de moda','Imagen para fotografía, pasarela, publicidad, producciones y marcas.','bi-stars'],
                ['Marca y emprendimiento','Colecciones propias, costos, producción, ventas y comercio digital.','bi-shop'],
            ]),
            'learning_paths' => $this->paths('Diseño, textiles, patronaje, confección, colección, producción y negocio.', 'Formación específica en costura, patronaje, ilustración, bordado, styling o producción.', 'Creación de prendas propias y proyectos personales sin obligación de comercializarlos.'),
            'professional_field' => 'Talleres de confección, empresas textiles, marcas, comercios, productoras, teatro, danza, agencias, departamentos de producto o una marca y taller propios.',
            'economic_scope' => 'Puede generar ingresos mediante empleo, diseño por encargo, confección, asesoría de imagen y venta de colecciones; emprender exige calcular materiales, tiempos, inventario y demanda.',
            'social_scope' => 'Puede visibilizar identidades y fortalecer cadenas productivas locales; debe evitar apropiación cultural, desperdicio y explotación laboral.',
            'international_scope' => 'El comercio digital permite llegar a otros mercados. Portafolio, técnica, proveedores, idioma, propiedad intelectual y adaptación de tallas y normas son importantes.',
            'icon' => 'bi-person-standing-dress', 'riasec_primary' => 'A', 'riasec_secondary' => 'E',
            'source_url' => 'https://www.bls.gov/ooh/arts-and-design/fashion-designers.htm',
            'source_name' => 'U.S. BLS — diseñadores de moda',
        ]);
    }

    private function save(int $areaId, array $data): void
    {
        $sourceName = $data['source_name']; unset($data['source_name']);
        $career = Career::updateOrCreate(['slug' => $data['slug']], $data + [
            'academic_area_id' => $areaId, 'degree_level' => 'Formación flexible',
            'is_traditional' => false, 'verified_at' => now(), 'is_active' => true,
        ]);
        CareerSource::updateOrCreate(['career_id' => $career->id, 'source_url' => $data['source_url']], [
            'source_name' => $sourceName, 'source_year' => 2026,
            'notes' => 'Referencia internacional de funciones y formación; no representa ingresos garantizados en Bolivia.', 'checked_at' => now(),
        ]);
    }

    private function items(array $items): array
    {
        return array_map(fn ($item) => ['name'=>$item[0], 'description'=>$item[1], 'icon'=>$item[2]], $items);
    }

    private function paths(string $complete, string $partial, string $personal): array
    {
        return [
            ['name'=>'Formación profesional completa','description'=>$complete,'icon'=>'bi-mortarboard'],
            ['name'=>'Formación parcial para trabajar','description'=>$partial,'icon'=>'bi-briefcase'],
            ['name'=>'Aprendizaje personal o hobby','description'=>$personal,'icon'=>'bi-heart'],
        ];
    }
}
