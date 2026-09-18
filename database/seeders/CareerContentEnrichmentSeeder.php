<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\CareerSource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerContentEnrichmentSeeder extends Seeder
{
    private const SOURCES = [
        'canada' => ['Gobierno de Canadá — selección por categorías', 'https://www.canada.ca/en/immigration-refugees-citizenship/corporate/publications-manuals/report-parliament-cbs-2024-25.html', 2025],
        'europe' => ['Autoridad Laboral Europea — escasez de ocupaciones', 'https://www.ela.europa.eu/en/publications/labour-shortages-and-surpluses-europe-2024', 2025],
        'usa' => ['U.S. Bureau of Labor Statistics — proyecciones 2024–2034', 'https://www.bls.gov/opub/mlr/2026/article/industry-and-occupational-employment-projections-overview.htm', 2026],
        'gastronomy' => ['INFOCAL Cochabamba — plan de Gastronomía', 'https://www.infocalcbba.edu.bo/gastronomia/', 2025],
        'mechanics' => ['UMSS — Ingeniería Mecánica', 'https://www.fcyt.umss.edu.bo/carrera/ingenieria-de-mecanica/', 2026],
    ];

    public function run(): void
    {
        Career::query()->where('is_active', true)->with('academicArea')->get()->each(function (Career $career) {
            $profile = $this->profile($career);
            $summary = trim((string) $career->summary);

            $career->update([
                'icon' => $this->iconFor($career->name),
                'description' => "{$career->name} es una formación orientada a {$profile['purpose']}. "
                    .($summary !== '' ? "En términos generales, {$summary} " : '')
                    ."La carrera combina fundamentos conceptuales con práctica progresiva para analizar problemas, tomar decisiones responsables y desarrollar soluciones propias de su campo. El perfil exacto, las materias y el título otorgado pueden variar entre universidades e institutos.",
                'study_focus' => "Durante la formación se trabajan {$profile['study']}. También se fortalecen la comunicación profesional, el trabajo en equipo, la ética, el uso de herramientas actuales y la aplicación de conocimientos mediante proyectos, talleres, laboratorios o prácticas, según el plan de estudios de cada institución.",
                'specializations' => $this->specializationsFor($career->name),
                'professional_field' => "En Bolivia, una persona formada en {$career->name} puede desenvolverse en {$profile['work']}. Las funciones concretas dependen del nivel del título, la experiencia, la especialización y los requisitos de contratación de cada organización.",
                'economic_scope' => "Puede aportar a {$profile['economic']}. La demanda y los ingresos no son uniformes: cambian según la ciudad, el sector público o privado, la experiencia, el tipo de contrato y la capacidad de emprender o especializarse.",
                'social_scope' => "Su aporte social se relaciona con {$profile['social']}, procurando una actuación ética, inclusiva y adaptada a las necesidades de las comunidades bolivianas.",
                'international_scope' => $profile['international'],
            ]);

            foreach ($profile['sources'] as $sourceKey) {
                [$name, $url, $year] = self::SOURCES[$sourceKey];
                CareerSource::updateOrCreate(
                    ['career_id' => $career->id, 'source_url' => $url],
                    ['source_name' => $name, 'source_year' => $year, 'notes' => 'Referencia oficial sobre tendencias ocupacionales internacionales; no garantiza empleo ni habilitación profesional.', 'checked_at' => now()]
                );
            }

            $careerName = Str::lower(Str::ascii($career->name));
            foreach (['gastronomy' => 'gastronom', 'mechanics' => 'mecanic'] as $sourceKey => $needle) {
                if (!$this->has($careerName, [$needle])) continue;
                [$name, $url, $year] = self::SOURCES[$sourceKey];
                CareerSource::updateOrCreate(
                    ['career_id' => $career->id, 'source_url' => $url],
                    ['source_name' => $name, 'source_year' => $year, 'notes' => 'Referencia institucional para áreas de formación y desarrollo profesional.', 'checked_at' => now()]
                );
            }
        });
    }

    private function profile(Career $career): array
    {
        $text = Str::lower(Str::ascii($career->name));

        if ($this->has($text, ['medicina', 'enfermer', 'odontolog', 'farmac', 'fisioter', 'laboratorio clin', 'bioquim', 'nutric', 'salud', 'optometr', 'fonoaudi'])) {
            return $this->make('bi-heart-pulse', 'prevenir, evaluar y atender necesidades relacionadas con la salud y el bienestar humano', 'ciencias básicas y clínicas, prevención, evaluación, procedimientos de atención, bioseguridad, investigación y práctica supervisada', 'hospitales, centros de salud, clínicas, laboratorios, programas comunitarios, docencia, investigación y servicios especializados', 'la calidad y eficiencia de los servicios de salud, la prevención y el desarrollo de soluciones sanitarias', 'la prevención de enfermedades, la recuperación funcional y una atención más accesible y humana', 'Presenta una proyección internacional relevante porque distintos mercados reportan escasez persistente de personal sanitario. Sin embargo, es un campo regulado: para ejercer suelen exigirse homologación del título, licencia o colegiatura local, idioma y, en algunos países, exámenes o prácticas adicionales. La especialización y la experiencia clínica verificable fortalecen el perfil.', ['canada', 'europe', 'usa']);
        }

        if ($this->has($text, ['informat', 'sistemas', 'software', 'comput', 'datos', 'ciber', 'telecomunic'])) {
            return $this->make('bi-code-slash', 'diseñar, implementar y mejorar soluciones digitales que respondan a necesidades organizacionales y sociales', 'programación, bases de datos, arquitectura de sistemas, redes, seguridad, análisis de información, gestión de proyectos y resolución lógica de problemas', 'empresas tecnológicas, banca, telecomunicaciones, industria, consultoría, instituciones públicas, emprendimientos y trabajo remoto', 'la transformación digital, la productividad, la innovación y la creación de servicios escalables', 'el acceso a información y servicios digitales seguros, útiles e inclusivos', 'Tiene potencial internacional alto por el crecimiento del software, los datos, la ciberseguridad y la digitalización. Parte del trabajo puede realizarse de forma remota, aunque la competencia es global. Un portafolio demostrable, inglés, experiencia práctica y certificaciones pertinentes suelen pesar junto al título.', ['canada', 'europe', 'usa']);
        }

        if ($this->has($text, ['ingenier', 'construccion', 'electric', 'electron', 'mecanic', 'mecatron', 'geolog', 'minas', 'petrole', 'hidrocarburo', 'industrial', 'arquitect'])) {
            return $this->make($this->engineeringIcon($text), 'planificar, diseñar, construir, operar o mejorar sistemas, infraestructura y procesos técnicos', 'matemática y ciencias aplicadas, representación técnica, diseño, materiales, seguridad, gestión de proyectos, normativa y herramientas especializadas', 'constructoras, industria, minería, energía, manufactura, consultoras, empresas de servicios, entidades públicas y supervisión de proyectos', 'la infraestructura, la productividad industrial, el aprovechamiento responsable de recursos y la modernización tecnológica', 'soluciones seguras y sostenibles para vivienda, producción, movilidad, energía y servicios esenciales', 'La ingeniería y varios oficios técnicos relacionados aparecen entre los campos con escasez en mercados como Canadá y Europa. La oportunidad concreta depende de la especialidad y del ciclo económico. Para cargos regulados puede requerirse reconocimiento profesional; experiencia en proyectos, normas internacionales, software técnico e idiomas mejora la movilidad.', ['canada', 'europe']);
        }

        if ($this->has($text, ['agronom', 'agropec', 'veterin', 'forest', 'ambient', 'recursos naturales', 'alimentos'])) {
            return $this->make('bi-tree', 'gestionar de manera técnica y sostenible la producción, los recursos naturales, los alimentos o la salud animal', 'biología y ciencias aplicadas, producción, calidad, sanidad, territorio, sostenibilidad, gestión y trabajo de campo', 'empresas productivas, fincas, laboratorios, municipios, organizaciones de desarrollo, industrias de alimentos, consultoras y emprendimientos', 'la seguridad alimentaria, las cadenas productivas, la innovación rural y el uso eficiente de recursos', 'la salud ambiental, el desarrollo territorial y mejores condiciones para productores y consumidores', 'Cuenta con oportunidades selectivas en agricultura, agroindustria, alimentos, sostenibilidad y gestión ambiental; Canadá incluye ocupaciones agroalimentarias entre sus áreas de necesidad. Para competir fuera convienen experiencia de campo, trazabilidad, normas de calidad, tecnología aplicada e idioma. Las profesiones reguladas, como Veterinaria, exigen habilitación local.', ['canada']);
        }

        if ($this->has($text, ['educacion', 'pedagog', 'profesor', 'maestro', 'docen', 'idioma', 'linguist', 'psicopedagog'])) {
            return $this->make('bi-book', 'facilitar aprendizajes y acompañar el desarrollo de personas en distintos contextos educativos', 'didáctica, currículo, evaluación, psicología del aprendizaje, inclusión, investigación educativa, tecnología y práctica docente', 'unidades educativas, institutos, universidades, programas sociales, capacitación empresarial, educación especial y proyectos educativos', 'la formación de capital humano, la capacitación continua y la mejora de los sistemas educativos', 'la inclusión, el pensamiento crítico y la ampliación de oportunidades mediante una educación de calidad', 'La educación figura entre las categorías de necesidad ocupacional consideradas por Canadá, pero la demanda varía por especialidad y región. Para ejercer en otro país suelen solicitar reconocimiento del título, dominio avanzado del idioma, antecedentes y certificación docente local. La experiencia inclusiva y digital puede diferenciar el perfil.', ['canada']);
        }

        if ($this->has($text, ['administracion', 'contadur', 'econom', 'finanz', 'comercio', 'marketing', 'auditor', 'secretariado', 'banca', 'aduana'])) {
            return $this->make('bi-briefcase', 'organizar recursos, analizar información y apoyar decisiones que mejoren el funcionamiento de empresas e instituciones', 'gestión, contabilidad y finanzas, economía, legislación, análisis de datos, procesos, comunicación comercial y planificación', 'empresas privadas, bancos, consultoras, cooperativas, instituciones públicas, organizaciones sociales y emprendimientos', 'la sostenibilidad de organizaciones, la formalización, la inversión, el comercio y la generación de empleo', 'la transparencia, la buena administración de recursos y el desarrollo de organizaciones responsables', 'Su proyección internacional es amplia pero competitiva y no implica una escasez uniforme. Resultan valiosos el conocimiento de normas internacionales, análisis de datos, inglés, experiencia multinacional y certificaciones. Contabilidad, auditoría o comercio pueden exigir adaptación a la legislación y credenciales del país de destino.', []);
        }

        if ($this->has($text, ['derecho', 'psicolog', 'sociolog', 'trabajo social', 'comunicacion', 'periodismo', 'historia', 'filosof', 'ciencia politica', 'relaciones internacional'])) {
            return $this->make('bi-people', 'comprender, orientar o intervenir en fenómenos humanos, jurídicos, comunicacionales y sociales', 'teorías del área, investigación, análisis crítico, normativa o metodologías de intervención, escritura, comunicación y estudio de casos', 'instituciones públicas, organizaciones sociales, consultoras, medios, centros educativos, investigación, gestión cultural y servicios profesionales', 'la formulación de políticas, la gestión institucional, la resolución de conflictos y la producción de conocimiento', 'la defensa de derechos, la participación ciudadana, la salud comunitaria y una mejor comprensión de la sociedad', 'La movilidad internacional es posible principalmente mediante posgrados, investigación, cooperación, organismos internacionales, comunicación o proyectos sociales. Su fortaleza depende mucho del idioma, la especialización y la experiencia. Derecho y varias profesiones de atención están reguladas o vinculadas a normas locales, por lo que requieren homologación o formación complementaria.', []);
        }

        if ($this->has($text, ['arte', 'diseno', 'musica', 'teatro', 'danza', 'audiovisual', 'fotograf', 'turismo', 'gastronom', 'hotel', 'belleza', 'peluquer', 'deporte'])) {
            return $this->make($this->creativeIcon($text), 'crear experiencias, productos o servicios culturales, visuales, turísticos, deportivos y de bienestar', 'técnicas propias de la especialidad, creatividad, cultura, atención al público, producción, gestión de proyectos, comunicación y práctica aplicada', 'estudios creativos, agencias, medios, hoteles, restaurantes, centros culturales o deportivos, servicios independientes, producción y emprendimientos', 'las industrias creativas, el turismo, los servicios, la economía cultural y los negocios independientes', 'la identidad cultural, el bienestar, la expresión, la recreación y el intercambio entre comunidades', 'La proyección exterior es selectiva y suele depender más de un portafolio sólido, experiencia, redes profesionales, idioma y adaptación cultural que del título por sí solo. Gastronomía y hotelería pueden hallar demanda en algunos mercados, mientras que las ocupaciones creativas son más variables. Conviene validar requisitos de visa, certificación y contratación del destino.', ['europe']);
        }

        return $this->make('bi-tools', 'aplicar conocimientos técnicos y procedimientos especializados para producir, instalar, mantener o prestar servicios con calidad', 'fundamentos técnicos, uso seguro de equipos y materiales, interpretación de procedimientos, control de calidad, mantenimiento y práctica de taller', 'talleres, plantas productivas, empresas de mantenimiento, construcción, servicios técnicos, instituciones y emprendimientos propios', 'la productividad, el mantenimiento de equipos, la sustitución de servicios importados y el autoempleo', 'servicios confiables, infraestructura funcional y soluciones prácticas para familias, empresas y comunidades', 'Los perfiles técnicos vinculados con electricidad, construcción, mantenimiento y producción registran escasez en diversos mercados europeos y canadienses. La experiencia comprobable, la seguridad ocupacional, certificaciones e idioma son claves; algunos oficios requieren licencia o evaluación de competencias en el país de destino.', ['canada', 'europe']);
    }

    private function make(string $icon, string $purpose, string $study, string $work, string $economic, string $social, string $international, array $sources): array
    {
        return compact('icon', 'purpose', 'study', 'work', 'economic', 'social', 'international', 'sources');
    }

    private function has(string $text, array $needles): bool
    {
        return Str::contains($text, $needles);
    }

    private function iconFor(string $name): string
    {
        $text = Str::lower(Str::ascii($name));

        return match (true) {
            $this->has($text, ['gastronom', 'cocina']) => 'bi-cup-hot',
            $this->has($text, ['medicina']) => 'bi-heart-pulse',
            $this->has($text, ['enfermer']) => 'bi-bandaid',
            $this->has($text, ['odontolog', 'protesis dental']) => 'bi-emoji-smile',
            $this->has($text, ['farmac', 'bioquim']) => 'bi-capsule',
            $this->has($text, ['laboratorio']) => 'bi-eyedropper',
            $this->has($text, ['nutric']) => 'bi-apple',
            $this->has($text, ['fisioter', 'deporte', 'actividad fisica']) => 'bi-person-walking',
            $this->has($text, ['optometr']) => 'bi-eye',
            $this->has($text, ['psicolog', 'psicopedagog']) => 'bi-chat-heart',
            $this->has($text, ['veterin']) => 'bi-heart-pulse',
            $this->has($text, ['informat', 'sistemas', 'software', 'programacion']) => 'bi-code-slash',
            $this->has($text, ['telecomunic']) => 'bi-broadcast-pin',
            $this->has($text, ['arquitect', 'civil', 'construccion']) => 'bi-buildings',
            $this->has($text, ['electric']) => 'bi-lightning-charge',
            $this->has($text, ['electron', 'mecatron']) => 'bi-cpu',
            $this->has($text, ['mecanic', 'automotriz']) => 'bi-gear-wide-connected',
            $this->has($text, ['petrole', 'hidrocarburo']) => 'bi-fuel-pump',
            $this->has($text, ['geolog', 'minas']) => 'bi-gem',
            $this->has($text, ['agronom', 'agropec', 'forest', 'ambient']) => 'bi-tree',
            $this->has($text, ['derecho']) => 'bi-bank',
            $this->has($text, ['contadur', 'auditor']) => 'bi-calculator',
            $this->has($text, ['econom', 'finanz', 'banca']) => 'bi-graph-up-arrow',
            $this->has($text, ['marketing']) => 'bi-bullseye',
            $this->has($text, ['administracion', 'comercio']) => 'bi-briefcase',
            $this->has($text, ['educacion', 'pedagog', 'profesor', 'maestro', 'docen']) => 'bi-book',
            $this->has($text, ['idioma', 'linguist']) => 'bi-translate',
            $this->has($text, ['comunicacion', 'periodismo']) => 'bi-megaphone',
            $this->has($text, ['trabajo social', 'sociolog']) => 'bi-people',
            $this->has($text, ['historia']) => 'bi-hourglass-split',
            $this->has($text, ['filosof']) => 'bi-lightbulb',
            $this->has($text, ['musica', 'danza']) => 'bi-music-note-beamed',
            $this->has($text, ['fotograf', 'audiovisual', 'cine']) => 'bi-camera-reels',
            $this->has($text, ['diseno', 'arte']) => 'bi-palette',
            $this->has($text, ['turismo', 'hotel']) => 'bi-airplane',
            $this->has($text, ['belleza', 'peluquer', 'textil', 'confeccion']) => 'bi-scissors',
            $this->has($text, ['secretariado']) => 'bi-folder-check',
            default => 'bi-tools',
        };
    }

    private function specializationsFor(string $name): ?array
    {
        $text = Str::lower(Str::ascii($name));
        $areas = match (true) {
            $this->has($text, ['formacion de maestros']) => [
                ['Educación Inicial', 'Docencia para la primera infancia dentro de la familia y la comunidad.', 'bi-people'],
                ['Educación Primaria', 'Formación integral para acompañar los aprendizajes del nivel primario.', 'bi-book'],
                ['Ciencias Sociales', 'Docencia de historia, geografía y comprensión de procesos sociales en secundaria.', 'bi-globe-americas'],
                ['Matemática', 'Enseñanza del razonamiento matemático y resolución de problemas en secundaria.', 'bi-calculator'],
                ['Biología y Geografía', 'Educación científica sobre seres vivos, ambiente, territorio y sociedad.', 'bi-tree'],
                ['Física y Química', 'Docencia experimental de materia, energía, fenómenos físicos y procesos químicos.', 'bi-lightning-charge'],
                ['Comunicación y Lenguajes', 'Enseñanza de Lengua Castellana o Lengua Extranjera, principalmente inglés.', 'bi-translate'],
                ['Educación Musical', 'Desarrollo de expresión, apreciación, interpretación y creación musical.', 'bi-music-note-beamed'],
                ['Educación Física y Deportes', 'Formación corporal, actividad física, recreación y práctica deportiva educativa.', 'bi-trophy'],
                ['Educación Especial', 'Atención educativa inclusiva para personas con discapacidad y diversas necesidades.', 'bi-universal-access'],
                ['Área Técnica Tecnológica', 'Especialidades productivas como Transformación de Alimentos y Gastronomía, según sede y convocatoria.', 'bi-tools'],
            ],
            $this->has($text, ['gastronom']) => [
                ['Cocina profesional', 'Técnicas culinarias bolivianas e internacionales, producción y presentación de platos.', 'bi-egg-fried'],
                ['Pastelería y repostería', 'Postres, masas, decoración, panificación y producción especializada.', 'bi-cake2'],
                ['Bar y coctelería', 'Preparación de bebidas, servicio, enología básica y maridaje responsable.', 'bi-cup-straw'],
                ['Gestión gastronómica', 'Costos, inocuidad, organización de cocina, alimentos y bebidas, eventos y emprendimiento.', 'bi-shop'],
            ],
            $this->has($text, ['mecatron']) => [
                ['Automatización y control', 'Sensores, actuadores, control industrial y mejora de procesos automatizados.', 'bi-sliders'],
                ['Robótica', 'Diseño, programación e integración de robots y sistemas inteligentes.', 'bi-robot'],
                ['Manufactura digital', 'Sistemas CNC, diseño asistido por computadora y producción flexible.', 'bi-cpu'],
                ['Mantenimiento mecatrónico', 'Diagnóstico y prevención de fallas en sistemas mecánicos, eléctricos y electrónicos.', 'bi-tools'],
            ],
            $this->has($text, ['mecanic', 'automotriz']) => [
                ['Diseño mecánico', 'Cálculo, modelado y desarrollo de máquinas, piezas y sistemas.', 'bi-rulers'],
                ['Manufactura y producción', 'Procesos de fabricación, materiales, calidad y organización industrial.', 'bi-gear'],
                ['Energía y sistemas térmicos', 'Termodinámica, refrigeración, fluidos y conversión de energía.', 'bi-thermometer-half'],
                ['Mantenimiento', 'Diagnóstico, planificación y conservación de equipos, vehículos o maquinaria.', 'bi-wrench-adjustable'],
            ],
            $this->has($text, ['informat', 'sistemas', 'software']) => [
                ['Desarrollo de software', 'Aplicaciones web, móviles, de escritorio y arquitectura de soluciones.', 'bi-code-slash'],
                ['Datos e inteligencia artificial', 'Análisis de datos, modelos predictivos, automatización y aprendizaje automático.', 'bi-bar-chart'],
                ['Ciberseguridad y redes', 'Protección de sistemas, infraestructura, comunicaciones y gestión de riesgos.', 'bi-shield-lock'],
                ['Gestión tecnológica', 'Proyectos, calidad, procesos, consultoría y transformación digital.', 'bi-kanban'],
            ],
            $this->has($text, ['medicina']) => [
                ['Atención clínica', 'Evaluación, diagnóstico y tratamiento en las diferentes etapas de la vida.', 'bi-hospital'],
                ['Salud pública', 'Prevención, epidemiología, promoción de la salud y trabajo comunitario.', 'bi-people'],
                ['Investigación y docencia', 'Producción de conocimiento, educación médica y evaluación de evidencia.', 'bi-journal-medical'],
                ['Especialidades médicas', 'Después del pregrado pueden cursarse residencias como cirugía, pediatría o medicina interna.', 'bi-heart-pulse'],
            ],
            $this->has($text, ['enfermer']) => [
                ['Atención clínica', 'Cuidados integrales en hospitales, centros de salud y servicios especializados.', 'bi-bandaid'],
                ['Salud comunitaria', 'Prevención, educación sanitaria y acompañamiento de familias y comunidades.', 'bi-people'],
                ['Gestión y docencia', 'Administración de servicios, calidad del cuidado y formación en salud.', 'bi-clipboard2-pulse'],
            ],
            $this->has($text, ['psicolog']) => [
                ['Psicología clínica', 'Evaluación, prevención y acompañamiento de la salud mental.', 'bi-chat-heart'],
                ['Psicología educativa', 'Aprendizaje, orientación y convivencia en contextos educativos.', 'bi-book'],
                ['Psicología organizacional', 'Selección, bienestar, capacitación y comportamiento en el trabajo.', 'bi-briefcase'],
                ['Psicología social', 'Intervención comunitaria, investigación y programas de desarrollo.', 'bi-people'],
            ],
            $this->has($text, ['arquitect']) => [
                ['Diseño arquitectónico', 'Creación de espacios funcionales considerando usuarios, contexto y estética.', 'bi-pencil-square'],
                ['Urbanismo y territorio', 'Planificación de ciudades, espacio público, movilidad y crecimiento urbano.', 'bi-buildings'],
                ['Construcción y tecnología', 'Materiales, sistemas constructivos, instalaciones y supervisión de obra.', 'bi-bricks'],
                ['Patrimonio y sostenibilidad', 'Conservación, eficiencia ambiental y adaptación responsable del entorno construido.', 'bi-tree'],
            ],
            $this->has($text, ['civil', 'construccion']) => [
                ['Estructuras', 'Análisis y diseño de edificaciones, puentes y obras resistentes.', 'bi-building'],
                ['Hidráulica y saneamiento', 'Agua potable, drenaje, riego y obras hidráulicas.', 'bi-droplet'],
                ['Vías y transporte', 'Carreteras, pavimentos, tránsito e infraestructura de movilidad.', 'bi-signpost-2'],
                ['Geotecnia y obras', 'Suelos, cimentaciones, materiales, costos y gestión de construcción.', 'bi-cone-striped'],
            ],
            $this->has($text, ['administracion']) => [
                ['Finanzas', 'Presupuestos, inversión, costos y decisiones sobre recursos.', 'bi-cash-coin'],
                ['Talento humano', 'Selección, capacitación, clima y desarrollo organizacional.', 'bi-people'],
                ['Operaciones', 'Procesos, logística, calidad y mejora de la productividad.', 'bi-diagram-3'],
                ['Emprendimiento y estrategia', 'Creación de negocios, innovación y planificación competitiva.', 'bi-rocket-takeoff'],
            ],
            $this->has($text, ['derecho']) => [
                ['Derecho civil y familiar', 'Relaciones entre personas, contratos, patrimonio y familia.', 'bi-people'],
                ['Derecho penal', 'Delitos, garantías, defensa y procedimiento penal.', 'bi-shield-check'],
                ['Derecho empresarial y laboral', 'Empresas, comercio, contratos y relaciones de trabajo.', 'bi-briefcase'],
                ['Derecho público e internacional', 'Estado, administración pública, derechos humanos y relaciones internacionales.', 'bi-globe-americas'],
            ],
            $this->has($text, ['comunicacion', 'periodismo']) => [
                ['Periodismo', 'Investigación, producción y verificación de información para distintos medios.', 'bi-newspaper'],
                ['Comunicación audiovisual', 'Guion, fotografía, sonido, video y narrativas digitales.', 'bi-camera-reels'],
                ['Comunicación corporativa', 'Reputación, contenidos, relaciones públicas y comunicación interna.', 'bi-megaphone'],
                ['Comunicación digital', 'Estrategia de redes, multimedia, audiencias y productos interactivos.', 'bi-phone'],
            ],
            $this->has($text, ['electric']) => [
                ['Sistemas eléctricos', 'Generación, transmisión, distribución e instalaciones eléctricas.', 'bi-lightning-charge'],
                ['Control industrial', 'Automatización, máquinas eléctricas e instrumentación.', 'bi-sliders'],
                ['Energías renovables', 'Integración y gestión de sistemas solares, eólicos y eficiencia energética.', 'bi-sun'],
            ],
            $this->has($text, ['electron']) => [
                ['Electrónica industrial', 'Control, potencia, instrumentación y automatización de procesos.', 'bi-cpu'],
                ['Telecomunicaciones', 'Señales, redes, transmisión y sistemas de comunicación.', 'bi-broadcast-pin'],
                ['Sistemas embebidos', 'Microcontroladores, sensores, programación y dispositivos inteligentes.', 'bi-motherboard'],
            ],
            $this->has($text, ['turismo', 'hotel']) => [
                ['Gestión hotelera', 'Alojamiento, recepción, calidad y experiencia del huésped.', 'bi-building'],
                ['Operación turística', 'Diseño de rutas, agencias, guiado y organización de viajes.', 'bi-map'],
                ['Turismo cultural y sostenible', 'Patrimonio, comunidades, naturaleza y gestión responsable de destinos.', 'bi-globe-americas'],
                ['Eventos y alimentos', 'Organización de eventos y coordinación de servicios gastronómicos.', 'bi-calendar-event'],
            ],
            $this->has($text, ['contadur', 'auditor']) => [
                ['Contabilidad financiera', 'Registro, estados financieros y análisis de información económica.', 'bi-calculator'],
                ['Auditoría', 'Evaluación de controles, riesgos y razonabilidad de la información.', 'bi-clipboard-check'],
                ['Tributación', 'Obligaciones fiscales, planificación y cumplimiento normativo.', 'bi-receipt'],
                ['Costos y gestión', 'Información para presupuestos, producción y decisiones empresariales.', 'bi-graph-up'],
            ],
            $this->has($text, ['agronom', 'agropec']) => [
                ['Producción vegetal', 'Cultivos, suelos, riego, sanidad y manejo productivo.', 'bi-flower1'],
                ['Producción animal', 'Nutrición, manejo, reproducción y sistemas pecuarios.', 'bi-heart-pulse'],
                ['Agroindustria', 'Transformación, calidad, cadenas de valor y comercialización.', 'bi-box-seam'],
                ['Gestión rural sostenible', 'Territorio, tecnología, extensión y uso responsable de recursos.', 'bi-tree'],
            ],
            default => null,
        };

        return $areas ? array_map(fn ($area) => ['name' => $area[0], 'description' => $area[1], 'icon' => $area[2]], $areas) : null;
    }

    private function engineeringIcon(string $text): string
    {
        return match (true) {
            $this->has($text, ['arquitect', 'civil', 'construccion']) => 'bi-buildings',
            $this->has($text, ['electric']) => 'bi-lightning-charge',
            $this->has($text, ['electron', 'mecatron']) => 'bi-cpu',
            $this->has($text, ['mecanic', 'automotriz']) => 'bi-gear-wide-connected',
            $this->has($text, ['petrole', 'gas']) => 'bi-fuel-pump',
            $this->has($text, ['geolog', 'minas']) => 'bi-gem',
            default => 'bi-rulers',
        };
    }

    private function creativeIcon(string $text): string
    {
        return match (true) {
            $this->has($text, ['musica', 'danza']) => 'bi-music-note-beamed',
            $this->has($text, ['gastronom']) => 'bi-cup-hot',
            $this->has($text, ['turismo', 'hotel']) => 'bi-airplane',
            $this->has($text, ['deporte']) => 'bi-trophy',
            $this->has($text, ['belleza', 'peluquer']) => 'bi-scissors',
            $this->has($text, ['audiovisual', 'fotograf']) => 'bi-camera-reels',
            default => 'bi-palette',
        };
    }
}
