<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\CareerSource;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class NonTraditionalCareersSeeder extends Seeder
{
    private const BLS_BEAUTY = 'https://www.bls.gov/ooh/personal-care-and-service/barbers-hairstylists-and-cosmetologists.htm';
    private const BLS_CREATIVE = 'https://www.bls.gov/ors/factsheet/arts-design-entertainment-sports-and-media-occupations.htm';
    private const IAB_CREATORS = 'https://www.iab.com/insights/2025-creator-economy-ad-spend-strategy-report/';

    public function run(): void
    {
        $area = AcademicArea::firstOrCreate(['name' => 'Carreras no tradicionales'], [
            'slug' => 'carreras-no-tradicionales',
            'description' => 'Profesiones construidas mediante formación técnica, práctica, portafolio, certificaciones y experiencia.',
            'icon' => '✦', 'color' => '#B7791F', 'is_active' => true,
        ]);

        foreach ($this->careers() as $data) {
            $sources = $data['sources'];
            unset($data['sources']);
            $career = Career::updateOrCreate(['slug' => $data['slug']], array_merge($data, [
                'academic_area_id' => $area->id,
                'is_traditional' => false,
                'riasec_primary' => $data['riasec_primary'] ?? 'A',
                'riasec_secondary' => $data['riasec_secondary'] ?? 'E',
                'verified_at' => now(), 'is_active' => true,
            ]));
            foreach ($sources as [$name, $url, $year]) {
                CareerSource::updateOrCreate(['career_id' => $career->id, 'source_url' => $url], [
                    'source_name' => $name, 'source_year' => $year,
                    'notes' => 'Referencia de tendencia internacional. No representa un salario ni una garantía de empleo en Bolivia.',
                    'checked_at' => now(),
                ]);
            }
        }

        $this->seedSecurityInstitutions();
    }

    private function careers(): array
    {
        return [
            $this->career('Estilismo y Belleza Integral', 'estilismo-y-belleza-integral', ['Estilista','Peluquería','Barbería','Manicura','Cosmetología','Cuidado de la piel','Maquillaje profesional'], 'De cursos breves a 2–3 años', 'Certificados o título técnico, según la institución', 'Integra servicios de imagen personal, cabello, uñas, maquillaje y cuidado estético no médico.', 'Forma para diagnosticar necesidades estéticas, aplicar técnicas seguras de imagen y atender clientes con higiene, creatividad y criterio profesional. La cosmetología estética no reemplaza dermatología ni otros servicios médicos.', 'Anatomía básica aplicada, bioseguridad, atención al cliente, colorimetría, técnicas estéticas, administración y práctica supervisada.', [
                ['Peluquería y color', 'Corte, peinado, tratamientos capilares, colorimetría y cuidado del cabello.', 'bi-scissors'],
                ['Barbería', 'Corte masculino, barba, afeitado, diseño y atención especializada.', 'bi-scissors'],
                ['Manicura y nail art', 'Cuidado de manos y pies, esmaltado, diseño y técnicas de uñas.', 'bi-hand-index'],
                ['Maquillaje profesional', 'Maquillaje social, editorial, audiovisual, artístico y para eventos.', 'bi-brush'],
                ['Estética y piel', 'Limpieza facial y cuidado cosmético no invasivo dentro de competencias habilitadas.', 'bi-stars'],
            ], $this->paths('Una formación integral permite ofrecer varios servicios o administrar un salón.', 'También puedes certificarte en corte, uñas, maquillaje o cuidado facial para trabajar en un servicio específico.', 'Puede aprenderse para autocuidado, creatividad o actividad complementaria, respetando siempre la bioseguridad.'), 'salones, barberías, spas, centros estéticos, producciones audiovisuales, hoteles, venta técnica de productos o atención a domicilio; también permite abrir un estudio propio', 'genera ingresos por servicios recurrentes, venta de productos y emprendimiento, aunque exige inversión en insumos, actualización y captación de clientes', 'fortalece bienestar e imagen personal, siempre que trabaje con inclusión, consentimiento, higiene y límites frente a procedimientos médicos', 'Existe movilidad, pero numerosos países exigen licencias locales. Portafolio, experiencia, normas sanitarias e idioma son decisivos.', 'bi-scissors', [['U.S. BLS — belleza y cosmetología', self::BLS_BEAUTY, 2026]]),

            $this->career('Modelaje Profesional', 'modelaje-profesional', ['Modelo de pasarela','Modelo publicitario','Modelo fotográfico','Modelo comercial'], 'Cursos de meses a 2 años', 'Certificación de academia y portafolio profesional', 'Desarrolla expresión corporal, presencia escénica y trabajo frente a cámara para moda, publicidad y producción visual.', 'El modelaje profesional combina técnica de pasarela, postura, interpretación visual, disciplina, autocuidado, comunicación y comprensión de contratos. No exige un único tipo de cuerpo: existen mercados comerciales, editoriales, de tallas diversas, manos, fitness y publicidad.', 'Pasarela, expresión corporal, fotografía, casting, styling, marca personal, derechos de imagen, contratos y seguridad profesional.', [
                ['Pasarela y moda', 'Desfiles, postura, ritmo, cambios y presentación de colecciones.', 'bi-person-standing-dress'],
                ['Comercial y publicitario', 'Campañas para marcas, catálogos, comercio electrónico y anuncios.', 'bi-badge-ad'],
                ['Editorial y fotográfico', 'Narrativa visual, poses, belleza y producción para publicaciones.', 'bi-camera'],
                ['Contenido y marca personal', 'Portafolio digital, redes, colaboración con marcas y comunicación.', 'bi-phone'],
            ], $this->paths('Una academia integral puede preparar para casting, pasarela, cámara y gestión profesional.', 'Talleres específicos permiten mejorar pasarela, pose fotográfica o expresión corporal.', 'Puede practicarse para seguridad personal, postura y comunicación, sin obligación de buscar representación.'), 'agencias, productoras, diseñadores, comercio electrónico, publicidad, televisión, eventos y trabajo independiente por campaña', 'los ingresos suelen ser irregulares y por proyecto; dependen del mercado, portafolio, representación, derechos de uso y reputación', 'aporta representación cultural y diversidad visual, pero requiere prevenir discriminación, estafas, explotación y estándares dañinos', 'La competencia es global y la contratación depende del portafolio, agencia, permisos y mercado. Conviene verificar contratos y nunca pagar promesas de empleo.', 'bi-person-bounding-box', [['U.S. BLS — ocupaciones artísticas y de medios', self::BLS_CREATIVE, 2025]]),

            $this->career('Formación Deportiva y Deporte Competitivo', 'formacion-deportiva-y-deporte-competitivo', ['Futbolista profesional','Atleta','Gimnasta','Deportista profesional','Entrenador deportivo'], 'Formación continua desde etapas iniciales', 'Certificaciones federativas, técnicas o trayectoria competitiva', 'Prepara para desarrollar rendimiento deportivo, competir o trabajar en funciones técnicas vinculadas al deporte.', 'Una carrera deportiva se construye con entrenamiento sistemático, evaluación física, competencia progresiva, hábitos saludables y acompañamiento técnico. La posibilidad de llegar al alto rendimiento depende de la disciplina, edad deportiva, oportunidades, salud y resultados; debe existir también un plan educativo alternativo.', 'Técnica y táctica, preparación física, psicología deportiva, nutrición, reglamento, prevención de lesiones, recuperación y análisis del rendimiento.', [
                ['Fútbol y deportes de equipo', 'Técnica, táctica, preparación colectiva y competencia organizada.', 'bi-dribbble'],
                ['Atletismo y resistencia', 'Carreras, saltos, lanzamientos y desarrollo de capacidades físicas.', 'bi-stopwatch'],
                ['Gimnasia y disciplinas artísticas', 'Fuerza, flexibilidad, coordinación, técnica y expresión.', 'bi-person-arms-up'],
                ['Entrenamiento y preparación física', 'Planificación, evaluación y acompañamiento seguro de deportistas.', 'bi-clipboard2-pulse'],
                ['Gestión y arbitraje', 'Organización deportiva, eventos, reglamentos y conducción de competencias.', 'bi-trophy'],
            ], $this->paths('La ruta competitiva exige club, entrenador, competencias y seguimiento multidisciplinario.', 'Puedes certificarte como entrenador, preparador, árbitro o monitor en una disciplina concreta.', 'También puede practicarse por salud, recreación y desarrollo personal sin convertirlo en profesión.'), 'clubes, asociaciones, federaciones, escuelas deportivas, gimnasios, municipios, eventos, patrocinadores o servicios independientes de entrenamiento', 'el alto rendimiento tiene ingresos muy desiguales y una carrera corta; entrenamiento, gestión y servicios deportivos ofrecen rutas complementarias más estables', 'promueve salud, disciplina, integración y representación, pero debe proteger a menores y prevenir lesiones, abuso y dopaje', 'Las oportunidades dependen de resultados, rankings, federaciones, agentes y visados. Las certificaciones de entrenamiento pueden requerir reconocimiento local.', 'bi-trophy', [['U.S. BLS — deporte, arte y medios', self::BLS_CREATIVE, 2025]]),

            $this->career('Creación de Contenido Digital', 'creacion-de-contenido-digital', ['Creador de contenido','YouTuber','Streamer','Influencer','Podcaster','TikToker'], 'Aprendizaje continuo; cursos de semanas a 2 años', 'Portafolio, métricas y certificaciones complementarias', 'Produce contenido para redes, video, transmisiones, pódcast y comunidades digitales con objetivos creativos o comerciales.', 'La creación de contenido une comunicación, investigación, guion, producción audiovisual, edición, estrategia de plataformas y relación con audiencias. Publicar no garantiza ingresos: la sostenibilidad requiere constancia, diferenciación, medición, diversificación y cumplimiento de derechos y normas publicitarias.', 'Narrativa, guion, cámara, iluminación, sonido, edición, diseño, analítica, marketing, propiedad intelectual, verificación y seguridad digital.', [
                ['Video y redes sociales', 'Contenido corto o largo para plataformas, marcas y comunidades.', 'bi-camera-video'],
                ['Streaming', 'Transmisión en vivo, realización, moderación y comunidad.', 'bi-broadcast'],
                ['Pódcast', 'Investigación, entrevista, voz, grabación, edición y distribución de audio.', 'bi-mic'],
                ['Contenido para marcas', 'Campañas, demostraciones, UGC y comunicación comercial transparente.', 'bi-badge-ad'],
                ['Educación y divulgación', 'Explicación responsable de conocimientos para audiencias digitales.', 'bi-lightbulb'],
            ], $this->paths('Una ruta completa combina estrategia, producción, negocio, ética y construcción de comunidad.', 'Puedes aprender solo edición, guion, fotografía, gestión de redes o streaming para trabajar como especialista.', 'También puedes crear por expresión, aprendizaje o comunidad sin convertir la audiencia en un negocio.'), 'agencias, equipos de marketing, medios, productoras, instituciones educativas, empresas o canales propios; también como editor, guionista, community manager o productor freelance', 'puede monetizar publicidad, patrocinios, servicios, membresías, afiliación y productos, pero los ingresos son volátiles y concentrados; las métricas no equivalen automáticamente a ganancias', 'democratiza la comunicación y educación, aunque implica responsabilidad frente a desinformación, privacidad, publicidad a menores y bienestar digital', 'El mercado puede ser global desde Bolivia. Idioma, nicho, calidad, derechos de autor y adaptación a plataformas ayudan, pero los algoritmos y pagos pueden cambiar.', 'bi-camera-video', [['IAB — inversión en economía de creadores 2025', self::IAB_CREATORS, 2025]]),

            $this->career('Escritura y Composición Creativa', 'escritura-y-composicion-creativa', ['Escritor','Escritora','Guionista','Compositor','Compositora','Copywriter'], 'Talleres breves a 4 años, según la ruta', 'Portafolio de obras, certificación o título relacionado', 'Desarrolla obras literarias, guiones, letras y contenidos escritos para cultura, medios, educación y comunicación.', 'La profesión se construye mediante lectura, práctica constante, revisión, investigación y publicación. El talento inicial necesita técnica, disciplina y comprensión del público, los géneros, los contratos y la propiedad intelectual.', 'Narrativa, poesía, dramaturgia, guion, estilo, edición, investigación, composición lírica, derechos de autor, publicación y presentación de proyectos.', [
                ['Literatura', 'Novela, cuento, poesía, ensayo y escritura para públicos diversos.', 'bi-book'],
                ['Guion', 'Historias para cine, televisión, animación, videojuegos y contenido digital.', 'bi-film'],
                ['Composición de letras', 'Creación lírica, estructura, métrica y colaboración musical.', 'bi-music-note-list'],
                ['Redacción profesional', 'Copywriting, contenido institucional, educativo, técnico o publicitario.', 'bi-pencil-square'],
                ['Edición y publicación', 'Corrección, preparación de originales y gestión editorial independiente.', 'bi-journal-text'],
            ], $this->paths('La formación completa desarrolla voz propia, varios géneros, edición, industria y derechos.', 'Talleres de guion, cuento, poesía, copywriting o composición permiten enfocarse en un producto laboral.', 'Escribir también es una práctica válida de expresión, memoria y disfrute sin obligación de publicar.'), 'editoriales, medios, agencias, productoras, instituciones, educación, videojuegos y proyectos propios; gran parte del trabajo se realiza por encargo o de forma independiente', 'combina regalías, derechos, ventas, encargos y servicios; la estabilidad suele mejorar al diversificar entre escritura, edición, docencia y comunicación', 'preserva memoria, idioma e identidad, estimula pensamiento crítico y crea nuevas narrativas para la sociedad', 'La distribución digital facilita llegar a otros países, pero traducción, representación, contratos y propiedad intelectual determinan el alcance económico.', 'bi-pencil-square', [['U.S. BLS — escritores y ocupaciones de medios', self::BLS_CREATIVE, 2025]]),

            $this->career('Producción e Ingeniería de Sonido', 'produccion-e-ingenieria-de-sonido', ['Ingeniería de sonido','Productor musical','DJ','Técnico de sonido','Diseñador sonoro'], 'Cursos de meses a 3–4 años', 'Certificación, título técnico o licenciatura según institución', 'Trabaja la captura, edición, mezcla, reproducción y diseño del sonido para música, eventos y medios audiovisuales.', 'Combina sensibilidad auditiva con tecnología. Incluye grabación, acústica, operación de equipos, producción musical y solución de problemas. Algunas instituciones otorgan títulos de ingeniería o licenciatura; otras forman técnicos, productores o DJ, por lo que debe revisarse el grado real de cada programa.', 'Audio digital, acústica, microfonía, grabación, mezcla, masterización, electrónica básica, software, producción, montaje, seguridad y derechos musicales.', [
                ['Grabación, mezcla y masterización', 'Producción técnica de música, voz y proyectos sonoros.', 'bi-sliders'],
                ['Sonido en vivo', 'Montaje y operación para conciertos, teatro, eventos y transmisiones.', 'bi-speaker'],
                ['Producción musical', 'Arreglos, dirección de sesiones, creación y desarrollo de artistas.', 'bi-music-note-beamed'],
                ['DJ y música electrónica', 'Selección, mezcla, performance y producción electrónica.', 'bi-disc'],
                ['Sonido audiovisual', 'Edición, ambientes, efectos y posproducción para cine, video y videojuegos.', 'bi-film'],
            ], $this->paths('La ruta completa integra fundamentos de audio, estudio, vivo, producción y negocio.', 'Cursos de DJ, mezcla, operación en vivo o software permiten prestar un servicio específico.', 'Puede aprenderse para producir música propia, mejorar un pódcast o disfrutar la experimentación sonora.'), 'estudios, radios, televisión, productoras, teatros, empresas de eventos, iglesias, agencias, videojuegos y servicios independientes de grabación o mezcla', 'los ingresos provienen de empleo técnico, sesiones, eventos, alquiler, producción y regalías; equipo, reputación y red de clientes influyen fuertemente', 'mejora el acceso a cultura, comunicación y memoria sonora, y exige cuidar niveles de ruido, audición y derechos de autor', 'El trabajo remoto de edición y mezcla abre clientes internacionales; eventos presenciales requieren redes locales, permisos y estándares técnicos.', 'bi-speaker', [['U.S. BLS — sonido, arte y medios', self::BLS_CREATIVE, 2025]]),

            $this->career('Danza Profesional', 'danza-profesional', ['Bailarín','Bailarina','Profesor de baile','Coreógrafo','Coreógrafa'], 'Cursos continuos a 3–5 años', 'Certificación, título artístico o trayectoria profesional', 'Desarrolla interpretación corporal, técnica, creación coreográfica y trabajo escénico en distintos géneros de danza.', 'La danza profesional requiere entrenamiento corporal continuo, musicalidad, interpretación, disciplina y cuidado de la salud. Puede orientarse a escena, enseñanza, coreografía, producción o proyectos comunitarios; la carrera interpretativa suele complementarse con docencia y gestión.', 'Técnica corporal, acondicionamiento, anatomía preventiva, musicalidad, improvisación, repertorio, coreografía, historia, puesta en escena y pedagogía.', [
                ['Danza contemporánea y clásica', 'Técnica, interpretación, repertorio y creación para escena.', 'bi-person-arms-up'],
                ['Danzas bolivianas y populares', 'Investigación, interpretación y preservación de expresiones culturales.', 'bi-people'],
                ['Danza urbana y comercial', 'Performance para escenarios, videoclips, eventos y medios.', 'bi-boombox'],
                ['Coreografía', 'Diseño de movimiento y dirección creativa de intérpretes.', 'bi-diagram-3'],
                ['Docencia de danza', 'Enseñanza progresiva y segura para diferentes edades y niveles.', 'bi-book'],
            ], $this->paths('Una formación integral combina técnica, interpretación, creación, historia y cuidado corporal.', 'Puedes especializarte mediante talleres en un género, coreografía o enseñanza.', 'La danza también puede practicarse como actividad cultural, recreativa y de bienestar.'), 'compañías, elencos, escuelas, centros culturales, teatros, eventos, televisión, videoclips, turismo y proyectos propios de enseñanza o producción', 'el empleo suele organizarse por temporada o proyecto; combinar interpretación, clases, coreografía y producción mejora la continuidad', 'fortalece identidad, expresión, salud, convivencia y patrimonio cultural, con práctica segura y respeto por los contextos culturales', 'Festivales, audiciones y residencias permiten movilidad, pero exigen portafolio audiovisual, nivel técnico, redes, idioma y cuidado físico.', 'bi-music-note-beamed', [['U.S. BLS — danza y ocupaciones artísticas', self::BLS_CREATIVE, 2025]]),

            $this->career('Carrera Policial', 'carrera-policial', ['Policía','Oficial de Policía','Subteniente de Policía','Sargento de Policía','Ciencias Policiales','ANAPOL','FATESCIPOL'], '2 años (sargentos) o 4 años (oficiales)', 'Técnico Superior o Licenciatura en Ciencias Policiales', 'Formación formal de régimen especial para servir en la Policía Boliviana como sargento u oficial.', 'La carrera policial prepara para proteger a la sociedad, prevenir delitos, mantener el orden y aplicar la normativa respetando los derechos humanos. No es un curso libre: el ingreso depende de convocatoria y evaluaciones, y la formación exige disciplina, aptitud física, condiciones médicas, rendimiento académico y conducta compatible con el servicio público.', 'Derecho, procedimientos policiales, investigación, seguridad, tránsito, administración, derechos humanos, acondicionamiento físico, ética, disciplina y prácticas en unidades policiales.', [
                ['Oficial de Policía — ANAPOL', 'Formación de 8 semestres; permite egresar con Licenciatura en Ciencias Policiales y grado jerárquico de Subteniente.', 'bi-shield-check'],
                ['Sargento de Policía — FATESCIPOL', 'Formación técnica de 4 semestres, incluido un periodo de prácticas; otorga Técnico Superior en Ciencias Policiales y grado de Sargento.', 'bi-person-badge'],
                ['Investigación Criminal', 'Métodos de investigación policial, criminalística, análisis de hechos y prevención criminal.', 'bi-search'],
                ['Orden y Seguridad', 'Prevención, mediación, auxilio y mantenimiento o restablecimiento del orden público.', 'bi-shield'],
                ['Tránsito y Vialidad', 'Prevención vial, transporte, circulación e investigación de hechos y accidentes de tránsito.', 'bi-signpost-2'],
                ['Administración Policial', 'Planificación, organización y control de recursos dentro de la institución policial.', 'bi-clipboard-data'],
            ], [], 'la Policía Boliviana, sus unidades territoriales y especializadas, de acuerdo con el grado, destino, normativa y necesidades institucionales', 'corresponde a una carrera pública institucional con escala, jerarquía y asignación de funciones; el ingreso y la permanencia no están garantizados por estudiar de manera externa', 'aporta a la seguridad, prevención, auxilio y convivencia; implica autoridad pública, riesgo, responsabilidad disciplinaria y obligación estricta de respetar derechos humanos', 'Es una carrera vinculada al Estado boliviano. Misiones, cooperación o estudios internacionales dependen de convenios y autorización institucional, no de libre contratación en policías extranjeras.', 'bi-shield-check', [['UNIPOL — ANAPOL', 'https://www.unipol.edu.bo/anapol-3/', 2026], ['UNIPOL — FATESCIPOL', 'https://www.unipol.edu.bo/fatescipol/', 2026]]),

            $this->career('Carrera Militar en las Fuerzas Armadas', 'carrera-militar-del-ejercito', ['Militar','Oficial del Ejército','Sargento del Ejército','Oficial de Aviación','Oficial Naval','Ciencias y Artes Militares','Colegio Militar','COLMIL'], 'Duración definida por la fuerza, instituto y convocatoria', 'Licenciatura o Técnico Superior en Ciencias y Artes Militares', 'Formación formal de régimen militar para incorporarse profesionalmente al Ejército, la Fuerza Aérea o la Armada Boliviana.', 'La carrera militar integra preparación académica, operativa, física, ética y disciplinaria para la defensa del Estado y el servicio institucional. No equivale al servicio militar obligatorio ni a un pasatiempo: requiere admisión oficial, régimen interno, cumplimiento de normas, aptitud integral y vocación de servicio.', 'Ciencias y artes militares, liderazgo, táctica, administración, acondicionamiento físico, derechos humanos, legislación, tecnología, logística, gestión de riesgos y práctica operativa según la fuerza y la ruta.', [
                ['Oficial del Ejército — Colegio Militar', 'Forma oficiales subalternos y conduce al título de Licenciatura en Ciencias y Artes Militares Terrestres otorgado por la universidad militar.', 'bi-award'],
                ['Sargento del Ejército — EMSE', 'Forma sargentos y otorga el nivel de Técnico Superior en Ciencia y Arte Militar Terrestre.', 'bi-person-badge'],
                ['Topografía militar — EMTE', 'Formación técnica superior en topografía aplicada a necesidades militares y al desarrollo nacional.', 'bi-map'],
                ['Música militar — EMME', 'Preparación profesional musical para las funciones, bandas y necesidades institucionales del Ejército.', 'bi-music-note-beamed'],
                ['Perfeccionamiento y especialización', 'Después de la formación inicial existen escuelas de armas, inteligencia, idiomas, equitación y comando para personal militar.', 'bi-diagram-3'],
                ['Oficial de Aviación — COLMILAV', 'Forma oficiales de aeronáutica y conduce a la Licenciatura en Ciencias y Artes Militares Aeronáuticas.', 'bi-airplane'],
                ['Oficial Naval — Escuela Naval Militar', 'Forma oficiales para la Armada Boliviana mediante preparación académica, naval, física y militar.', 'bi-water'],
            ], [], 'el Ejército de Bolivia en unidades operativas, administrativas, logísticas, técnicas y de apoyo, según jerarquía, especialidad, destino y necesidades institucionales', 'es una carrera pública jerarquizada; las condiciones económicas dependen del grado, antigüedad, destino y normativa institucional vigente', 'contribuye a defensa, soberanía, apoyo en emergencias y desarrollo nacional; supone disciplina, movilidad, riesgo y responsabilidades legales especiales', 'La proyección internacional se realiza principalmente mediante cursos, misiones de paz, intercambios o cooperación autorizados por las Fuerzas Armadas.', 'bi-award', [['Ejército de Bolivia — institutos de formación', 'https://ejercito.mil.bo/then3wpag/template_e_commerce/incorporate.php', 2026]]),
        ];
    }

    private function seedSecurityInstitutions(): void
    {
        $institutions = [
            ['la-paz','La Paz','academia-nacional-de-policias-anapol','Academia Nacional de Policías','ANAPOL','Academia policial','Zona Bajo Seguencoma, avenida Hugo Ernest N.º 7404','https://www.unipol.edu.bo/anapol-3/','carrera-policial','Licenciatura en Ciencias Policiales','4 años',true],
            ['la-paz','El Alto','fatescipol-el-alto','FATESCIPOL El Alto','FATESCIPOL','Facultad técnica policial','Av. Circunvalación entre Av. José Manuel Pando y calle A-2, zona Paraíso','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['oruro','Caracollo','fatescipol-caracollo','FATESCIPOL Caracollo','FATESCIPOL','Facultad técnica policial','Av. Bernal, junto a la doble vía La Paz–Oruro','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['potosi','Potosí','fatescipol-potosi','FATESCIPOL Potosí','FATESCIPOL','Facultad técnica policial','Zona Campamento Pailaviri, avenida El Minero s/n','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['chuquisaca','Sucre','fatescipol-sucre','FATESCIPOL Sucre','FATESCIPOL','Facultad técnica policial','Av. Circunvalación s/n, zona Bajo Aranjuez','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['tarija','Tarija','fatescipol-tarija','FATESCIPOL Tarija','FATESCIPOL','Facultad técnica policial','Barrio El Tejar, calle España','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['cochabamba','Sacaba','fatescipol-cochabamba','FATESCIPOL Cochabamba','FATESCIPOL','Facultad técnica policial','Zona Chimboco, municipio de Sacaba','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['santa-cruz','Santa Cruz de la Sierra','fatescipol-santa-cruz','FATESCIPOL Santa Cruz','FATESCIPOL','Facultad técnica policial','Av. Alemana, cuarto anillo, zona Andrés Ibáñez Norte','https://www.unipol.edu.bo/fatescipol/','carrera-policial','Técnico Superior en Ciencias Policiales','2 años',true],
            ['cochabamba','Sacaba','escuela-basica-policial-de-musica-esbapolmus','Escuela Básica Policial de Música','ESBAPOLMUS','Escuela policial','Zona Chimboco, municipio de Sacaba','https://www.unipol.edu.bo/','carrera-policial','Formación policial musical de régimen especial','Consultar convocatoria',true],
            ['la-paz','La Paz','colegio-militar-del-ejercito-gualberto-villarroel','Colegio Militar del Ejército Cnl. Gualberto Villarroel','COLMIL','Instituto militar','Zona Sur, frente a la estación del Teleférico Verde de Irpavi','https://mail.colmil.mil.bo/contacto.html','carrera-militar-del-ejercito','Licenciatura en Ciencias y Artes Militares Terrestres','Consultar convocatoria',true],
            ['cochabamba','Tarata','escuela-militar-de-sargentos-maximiliano-paredes','Escuela Militar de Sargentos del Ejército Sgto. Maximiliano Paredes Tejerina','EMSE','Instituto militar','Instalaciones de la EMSE, municipio de Tarata, provincia Esteban Arze','https://ejercito.mil.bo/then3wpag/template_e_commerce/incorporate.php','carrera-militar-del-ejercito','Técnico Superior en Ciencia y Arte Militar Terrestre','Consultar convocatoria',true],
            ['santa-cruz','Santa Cruz de la Sierra','colegio-militar-de-aviacion-german-busch','Colegio Militar de Aviación Tgral. Germán Busch Becerra','COLMILAV','Instituto militar aeronáutico','Av. Santos Dumont entre segundo y tercer anillo','https://fab.mil.bo/colmilav/','carrera-militar-del-ejercito','Licenciatura en Ciencias y Artes Militares Aeronáuticas','Consultar convocatoria',true],
            ['cochabamba','Carcaje','escuela-naval-militar-eduardo-avaroa','Escuela Naval Militar Eduardo Avaroa Hidalgo','ENM','Instituto militar naval','Localidad de Carcaje, municipio de Tolata, Cochabamba','https://www.armada.mil.bo/','carrera-militar-del-ejercito','Formación de oficiales navales','Consultar convocatoria',true],
        ];
        foreach ($institutions as [$departmentSlug,$city,$slug,$name,$acronym,$type,$address,$website,$careerSlug,$level,$duration,$verified]) {
            $department = Department::where('slug', $departmentSlug)->firstOrFail();
            $institution = Institution::updateOrCreate(['slug'=>$slug], [
                'department_id'=>$department->id, 'name'=>$name, 'acronym'=>$acronym,
                'institution_type'=>$type, 'ownership'=>'Pública', 'payment_type'=>'Gratuita',
                'description'=>'Institución pública de régimen especial que desarrolla formación profesional sujeta a convocatoria, evaluaciones y normativa institucional.',
                'cost_notes'=>'Revisar costos de postulación, documentos, uniformes, materiales y demás condiciones en la convocatoria vigente.',
                'schedule_notes'=>'Formación presencial de régimen especial y dedicación definida por la institución.',
                'city'=>$city, 'address'=>$address, 'website'=>$website, 'source_url'=>$website,
                'is_verified'=>$verified, 'verified_at'=>$verified ? now() : null, 'is_active'=>true,
            ]);
            $career = Career::where('slug',$careerSlug)->firstOrFail();
            $institution->careers()->syncWithoutDetaching([$career->id=>[
                'degree_level'=>$level, 'modality'=>'Presencial — régimen especial',
                'schedule'=>'Dedicación y régimen definidos por convocatoria', 'duration_text'=>$duration,
                'labor_demand'=>'Institucional', 'labor_demand_notes'=>'La incorporación depende del proceso oficial, aprobación, egreso y normativa institucional.',
                'admission_requirements'=>'Cumplir la convocatoria oficial y todas las evaluaciones académicas, médicas, físicas, psicológicas y documentales aplicables.',
                'is_active'=>true,
            ]]);
        }
    }

    private function career(string $name, string $slug, array $aliases, string $duration, string $title, string $summary, string $description, string $study, array $specializations, array $paths, string $work, string $economic, string $social, string $international, string $icon, array $sources): array
    {
        return ['name'=>$name,'slug'=>$slug,'alternative_names'=>$aliases,'degree_level'=>'Formación flexible','duration_text'=>$duration,'reference_title'=>$title,'summary'=>$summary,'description'=>$description,'study_focus'=>$study,'specializations'=>$this->specializations($specializations),'learning_paths'=>$paths,'professional_field'=>"Puedes trabajar en {$work}.",'economic_scope'=>ucfirst($economic).'. No existe un ingreso garantizado: depende de experiencia, calidad, ubicación, clientes, contratos y capacidad de gestión.','social_scope'=>ucfirst($social).'.','international_scope'=>$international,'icon'=>$icon,'source_url'=>$sources[0][1],'sources'=>$sources];
    }

    private function specializations(array $items): array
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
