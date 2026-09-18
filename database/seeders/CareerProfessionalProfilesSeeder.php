<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerProfessionalProfilesSeeder extends Seeder
{
    public function run(): void
    {
        Career::query()->where('is_active', true)->with('academicArea')->get()
            ->each(function (Career $career): void {
                [$work, $economy, $society] = $this->profile($career);
                $career->update([
                    'professional_field' => "En Bolivia, quien se forma en {$career->name} puede trabajar en {$work}. El cargo concreto depende del nivel del título, la experiencia, la especialización y, cuando corresponde, la habilitación profesional.",
                    'economic_scope' => "Esta carrera aporta a {$economy}. La demanda y los ingresos no son uniformes: cambian según el departamento, el sector, la experiencia y el tipo de contratación o emprendimiento.",
                    'social_scope' => "Su aporte social se relaciona con {$society}. Para que ese aporte sea positivo se requiere ejercicio ético, actualización y atención a las necesidades de la población boliviana.",
                    'international_scope' => $this->internationalScope($career),
                ]);
            });
    }

    private function internationalScope(Career $career): string
    {
        $slug = $career->slug;
        $area = $career->academicArea?->slug ?? '';
        $base = "La formación boliviana en {$career->name} puede utilizarse para postular a estudios, empleos o proyectos en otros países, pero no garantiza contratación ni habilitación automática.";

        if (Str::contains($slug, ['carrera-militar', 'carrera-policial'])) {
            return "{$base} Su ejercicio operativo está ligado a las instituciones y leyes de cada Estado, por lo que la transferencia directa es limitada. La experiencia puede proyectarse hacia gestión de riesgos, seguridad, investigación, logística, cooperación, derechos humanos o estudios especializados, según requisitos migratorios e institucionales.";
        }
        if (Str::contains($slug, ['medicina', 'enfermeria', 'odontologia', 'quimica-farmaceutica', 'veterinaria', 'fisioterapia', 'fonoaudiologia', 'optometria', 'laboratorio'])) {
            return "{$base} Es un campo habitualmente regulado: antes de atender pacientes o ejercer funciones reservadas suelen exigirse evaluación del título, licencia, idioma y, según el destino, exámenes, prácticas supervisadas o formación complementaria. Investigación, salud pública y posgrados tienen procesos de admisión distintos.";
        }
        if (Str::contains($slug, ['derecho'])) {
            return "{$base} El ejercicio jurídico depende de la legislación y colegiación del país de destino; normalmente requiere reconocimiento y estudio del derecho local. Existen rutas relacionadas con cumplimiento normativo, arbitraje, derechos humanos, cooperación, investigación y estudios internacionales.";
        }
        if (Str::contains($slug, ['arquitectura', 'ingenieria', 'construccion', 'topografia'])
            && ! Str::contains($slug, ['informatica', 'sistemas', 'software'])) {
            return "{$base} Para firmar proyectos o asumir responsabilidades reservadas puede requerirse reconocimiento profesional y registro local. Experiencia verificable, normas internacionales, software técnico, gestión de proyectos, seguridad e idioma fortalecen opciones en empresas, consultoras y posgrados.";
        }
        if (Str::contains($slug, ['informatica', 'sistemas', 'software', 'contenido-digital'])) {
            return "{$base} Tiene movilidad relativamente alta porque muchas funciones se evalúan mediante experiencia y resultados. Un portafolio, repositorios, inglés, trabajo colaborativo, seguridad y tecnologías vigentes facilitan postulaciones internacionales y remotas; cada empleador define sus requisitos.";
        }
        if (Str::contains($slug, ['contaduria', 'economia', 'financiera', 'administracion', 'comercio', 'marketing', 'secretariado'])) {
            return "{$base} Su proyección mejora con idiomas, análisis de datos, experiencia multinacional y conocimiento de normas del destino. Contabilidad, auditoría, tributación y ciertas funciones financieras pueden exigir certificaciones o adaptación a legislación local; negocios y comercio admiten rutas corporativas, consultoría y posgrado.";
        }
        if (Str::contains($slug, ['educacion', 'maestros', 'parvularia'])) {
            return "{$base} La docencia escolar suele estar regulada y puede requerir reconocimiento, certificación pedagógica, antecedentes e idioma avanzado. También existen rutas en educación digital, diseño curricular, cooperación, investigación, enseñanza de idiomas y posgrados.";
        }
        if (Str::contains($slug, ['artes', 'diseno', 'danza', 'musica', 'canto', 'teatro', 'literatura', 'escritura', 'sonido', 'modelaje', 'belleza'])) {
            return "{$base} La movilidad depende especialmente del portafolio, audiciones, experiencia, redes, derechos de autor, idioma y adaptación cultural. Festivales, producciones, residencias, formación, servicios independientes y plataformas digitales ofrecen rutas posibles, sujetas a visado y contratación.";
        }
        if (Str::contains($slug, ['gastronomia', 'hoteleria', 'turismo'])) {
            return "{$base} La experiencia práctica, idiomas, inocuidad, atención al cliente y estándares de servicio son relevantes. Algunos destinos o puestos exigen certificados sanitarios, licencias o acreditación como guía; hoteles, restaurantes, cruceros, eventos y formación especializada son rutas posibles.";
        }
        if (in_array($area, ['agropecuaria-y-medio-ambiente', 'ciencias-naturales-y-exactas'], true)) {
            return "{$base} Puede proyectarse mediante investigación, posgrados, producción, laboratorios, sostenibilidad y cooperación. Resultan valiosos el inglés, manejo de datos, estándares de calidad, experiencia de campo y conocimiento de regulación ambiental, sanitaria o productiva del destino.";
        }
        if (in_array($area, ['industria-y-mecanica', 'tecnologia-e-informatica'], true)) {
            return "{$base} La experiencia demostrable, seguridad ocupacional, lectura técnica, certificaciones e idioma favorecen la movilidad. Algunos oficios e instalaciones requieren licencia o evaluación de competencias; manufactura, mantenimiento, automatización y soporte ofrecen rutas según el mercado de destino.";
        }

        return "{$base} Conviene fortalecer idioma, experiencia verificable, portafolio o investigación y revisar si la ocupación está regulada. La autoridad del país de destino define reconocimiento académico, licencia, visado y documentos necesarios.";
    }

    private function profile(Career $career): array
    {
        $slug = $career->slug;
        $area = $career->academicArea?->slug ?? '';

        if (Str::contains($slug, ['actividad-fisica', 'formacion-deportiva'])) {
            return ['unidades educativas, clubes, gimnasios, escuelas deportivas, municipios y programas de salud y recreación', 'los servicios deportivos, el entrenamiento, la gestión de instalaciones y eventos y los emprendimientos de bienestar', 'la prevención del sedentarismo, el desarrollo motor, la convivencia y una actividad física segura e inclusiva'];
        }
        if (Str::contains($slug, ['carrera-militar'])) {
            return ['las Fuerzas Armadas, unidades operativas, logística, comunicaciones, ingeniería, gestión de riesgos y apoyo en emergencias', 'la logística nacional, la administración de recursos, la infraestructura y la respuesta estatal ante contingencias', 'la defensa del Estado, el apoyo humanitario y la atención de desastres conforme a la normativa militar'];
        }
        if (Str::contains($slug, ['carrera-policial'])) {
            return ['la Policía Boliviana, investigación, tránsito, criminalística, prevención, seguridad ciudadana y gestión institucional', 'la protección de actividades y bienes, la investigación del delito y la prestación de servicios públicos de seguridad', 'la prevención de violencia y delitos, el auxilio a la población y la convivencia con respeto a los derechos humanos'];
        }
        if (Str::contains($slug, ['acuicultura', 'piscicultura'])) {
            return ['centros piscícolas, asociaciones, criaderos, plantas de procesamiento, laboratorios y proyectos amazónicos o rurales', 'la producción sostenible de pescado, el abastecimiento alimentario, la transformación y los ingresos de productores', 'la seguridad alimentaria, el desarrollo rural y el manejo responsable del agua y de las especies'];
        }
        if (Str::contains($slug, ['medicina-veterinaria', 'veterinaria'])) {
            return ['clínicas veterinarias, producción pecuaria, laboratorios, frigoríficos, salud pública y asistencia técnica rural', 'la sanidad y productividad animal, la inocuidad alimentaria y las cadenas pecuarias', 'la prevención de zoonosis, el bienestar animal, la seguridad alimentaria y el apoyo a familias productoras'];
        }
        if (Str::contains($slug, ['turismo', 'hoteleria'])) {
            return ['hoteles, agencias, operadores turísticos, restaurantes, municipios, áreas protegidas, eventos y emprendimientos', 'el turismo, la generación de servicios y la articulación del transporte, alojamiento, gastronomía y cultura', 'la valoración del patrimonio, la atención responsable al visitante y el desarrollo de destinos con participación comunitaria'];
        }
        if (Str::contains($slug, ['gastronomia'])) {
            return ['restaurantes, hoteles, catering, panaderías, industria alimentaria, eventos, docencia y negocios propios', 'los servicios de alimentos, el turismo, la producción local y la creación de emprendimientos gastronómicos', 'la alimentación segura, la valoración de la cocina boliviana y la preservación del patrimonio culinario'];
        }
        if (Str::contains($slug, ['informatica', 'sistemas', 'software'])) {
            return ['empresas tecnológicas, banca, telecomunicaciones, industria, consultoras, entidades públicas, startups y trabajo remoto', 'la digitalización, el software, los datos, la automatización y la productividad de organizaciones', 'el acceso seguro e inclusivo a servicios digitales para educación, salud, producción y gestión pública'];
        }
        if (Str::contains($slug, ['contaduria'])) {
            return ['empresas, entidades públicas, bancos, cooperativas, auditorías, consultoras, tributación y ejercicio independiente', 'el control financiero, la tributación, la evaluación de costos y la toma de decisiones', 'la transparencia, la rendición de cuentas y la formalización de organizaciones y emprendimientos'];
        }
        if (Str::contains($slug, ['derecho'])) {
            return ['bufetes, tribunales, fiscalías, defensorías, notarías, empresas, entidades públicas, ONG y mediación', 'la seguridad jurídica, el cumplimiento normativo y la resolución de controversias', 'el acceso a justicia, la defensa de derechos y la convivencia democrática'];
        }
        if (Str::contains($slug, ['danza', 'musica', 'canto', 'teatro', 'artes', 'diseno', 'contenido', 'escritura', 'literatura', 'sonido', 'modelaje'])) {
            return ['estudios, elencos, agencias, medios, centros culturales, educación, eventos, producción y proyectos independientes', 'las industrias creativas, la producción cultural, la comunicación, los espectáculos y los emprendimientos', 'la expresión, la identidad cultural, la educación y el acceso de diversos públicos al arte y la comunicación'];
        }

        return match ($area) {
            'salud-y-bienestar' => ['hospitales, centros de salud, clínicas, laboratorios, programas comunitarios, investigación, docencia y servicios especializados', 'la prevención, el diagnóstico, la rehabilitación y la calidad de los servicios sanitarios', 'la protección de la salud, la autonomía, la educación sanitaria y el acceso oportuno a la atención'],
            'agropecuaria-y-medio-ambiente' => ['empresas productivas, predios, asociaciones, laboratorios, municipios, consultoras, investigación y proyectos rurales', 'la producción, el valor agregado, la seguridad alimentaria y el manejo sostenible de recursos', 'el desarrollo rural, la conservación, la resiliencia climática y el bienestar de productores y consumidores'],
            'administracion-y-economia' => ['empresas, bancos, cooperativas, entidades públicas, consultoras, organizaciones y emprendimientos', 'la gestión de recursos, las finanzas, el comercio, la productividad y la creación de empleo', 'la administración responsable, la inclusión económica y la provisión sostenible de bienes y servicios'],
            'ingenieria-y-tecnologia', 'industria-y-mecanica', 'construccion-y-territorio' => ['industria, constructoras, minería, energía, consultoras, mantenimiento, supervisión, entidades públicas y proyectos técnicos', 'la infraestructura, la productividad, la energía, el mantenimiento y la mejora de procesos y sistemas', 'la seguridad, los servicios básicos y soluciones técnicas sostenibles para hogares, producción y territorio'],
            'ciencias-sociales-y-juridicas' => ['instituciones públicas, ONG, consultoras, universidades, cooperación, investigación y proyectos sociales', 'la planificación, el análisis institucional, la evaluación de proyectos y la gestión pública y privada', 'la protección de derechos, la participación, la convivencia y políticas mejor adaptadas a la sociedad'],
            'humanidades-y-educacion' => ['unidades educativas, universidades, centros culturales, municipios, ONG, investigación y proyectos educativos', 'la formación de capacidades, la gestión educativa, la cultura y la producción de conocimiento', 'el derecho a la educación, el pensamiento crítico, la inclusión y la preservación de la memoria y las lenguas'],
            'ciencias-naturales-y-exactas' => ['laboratorios, universidades, industria, minería, ambiente, investigación, docencia y servicios científicos', 'la investigación aplicada, el análisis, el control de calidad y la innovación científica y productiva', 'la educación científica y soluciones rigurosas para problemas ambientales, sanitarios y tecnológicos'],
            'gastronomia-y-servicios' => ['empresas de servicios, hoteles, comercios, talleres, producción, atención al cliente y emprendimientos', 'la prestación de servicios, el autoempleo, el turismo, la producción y el comercio local', 'el bienestar, la atención segura y de calidad y oportunidades de formación y trabajo independiente'],
            'tecnologia-e-informatica' => ['empresas tecnológicas, telecomunicaciones, entidades públicas, industria, soporte y emprendimientos digitales', 'la conectividad, la digitalización, el mantenimiento tecnológico y la mejora de servicios', 'el acceso a información y comunicación y la reducción de brechas digitales'],
            default => ['empresas, instituciones, organizaciones, proyectos y servicios especializados relacionados con esta formación', 'la prestación de servicios, la innovación, la mejora de procesos y la actividad productiva', 'la solución responsable de necesidades y el fortalecimiento de personas y comunidades'],
        };
    }
}
