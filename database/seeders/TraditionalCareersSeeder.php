<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TraditionalCareersSeeder extends Seeder
{
    public function run(): void
    {
        $areaData = [
            ['Salud y bienestar', 'Salud, prevención, diagnóstico, tratamiento y bienestar humano.', '♡', '#16A34A'],
            ['Ingeniería y tecnología', 'Diseño y aplicación de soluciones científicas y tecnológicas.', '⚙', '#2563EB'],
            ['Ciencias naturales y exactas', 'Estudio científico de la naturaleza, la materia y los datos.', '⌬', '#0891B2'],
            ['Ciencias sociales y jurídicas', 'Sociedad, derecho, política, comunicación y desarrollo humano.', '◉', '#7C3AED'],
            ['Humanidades y educación', 'Educación, pensamiento, cultura, lenguaje e historia.', '◇', '#C2410C'],
            ['Arte, diseño y arquitectura', 'Creación, comunicación visual, espacios y expresión artística.', '✦', '#DB2777'],
            ['Agropecuaria y medio ambiente', 'Producción sostenible, animales, cultivos y recursos naturales.', '♧', '#15803D'],
        ];

        foreach ($areaData as [$name, $description, $icon, $color]) {
            AcademicArea::updateOrCreate(['slug' => Str::slug($name)], compact('name', 'description', 'icon', 'color') + ['is_active' => true]);
        }

        $items = [
            ['Medicina','Salud y bienestar','I','S',6,6,'Médico Cirujano','Estudia la prevención, diagnóstico, tratamiento y rehabilitación de enfermedades, integrando ciencias básicas, clínicas y sociales.'],
            ['Enfermería','Salud y bienestar','S','I',4,5,'Licenciado/a en Enfermería','Forma profesionales para brindar cuidados integrales de salud a personas, familias y comunidades.'],
            ['Odontología','Salud y bienestar','I','R',5,6,'Cirujano/a Dentista','Aborda la prevención, diagnóstico y tratamiento de enfermedades de la salud bucal.'],
            ['Nutrición y Dietética','Salud y bienestar','I','S',4,5,'Licenciado/a en Nutrición y Dietética','Estudia la alimentación y su relación con la salud individual y colectiva.'],
            ['Bioquímica','Salud y bienestar','I','C',5,5,'Licenciado/a en Bioquímica','Analiza procesos químicos y biológicos aplicados a salud, laboratorio e investigación.'],
            ['Química Farmacéutica','Salud y bienestar','I','C',5,5,'Licenciado/a en Química Farmacéutica','Estudia medicamentos, su elaboración, control, uso seguro y efectos en el organismo.'],
            ['Psicología','Ciencias sociales y jurídicas','S','I',5,5,'Licenciado/a en Psicología','Estudia el comportamiento, los procesos mentales y el bienestar psicológico.'],
            ['Derecho','Ciencias sociales y jurídicas','E','S',5,5,'Licenciado/a en Derecho','Estudia las normas jurídicas, los derechos y los mecanismos para resolver conflictos y administrar justicia.'],
            ['Ciencia Política y Gestión Pública','Ciencias sociales y jurídicas','E','I',4,5,'Licenciado/a en Ciencia Política','Analiza el poder, el Estado, las políticas públicas y la gestión de instituciones.'],
            ['Trabajo Social','Ciencias sociales y jurídicas','S','E',4,5,'Licenciado/a en Trabajo Social','Interviene en problemáticas sociales y promueve derechos, inclusión y bienestar comunitario.'],
            ['Sociología','Ciencias sociales y jurídicas','I','S',4,5,'Licenciado/a en Sociología','Estudia las relaciones, estructuras y transformaciones de la sociedad.'],
            ['Antropología y Arqueología','Ciencias sociales y jurídicas','I','A',5,5,'Licenciado/a en Antropología y Arqueología','Estudia culturas, sociedades y evidencias materiales del pasado y presente.'],
            ['Comunicación Social','Ciencias sociales y jurídicas','A','S',4,5,'Licenciado/a en Comunicación Social','Forma profesionales para investigar, producir y gestionar procesos de comunicación.'],
            ['Administración de Empresas','Administración y economía','E','C',4,5,'Licenciado/a en Administración de Empresas','Estudia la gestión estratégica de organizaciones, personas, operaciones y recursos.'],
            ['Contaduría Pública','Administración y economía','C','E',4,5,'Licenciado/a en Contaduría Pública','Forma profesionales para gestionar y controlar información contable, financiera y tributaria.'],
            ['Economía','Administración y economía','I','E',4,5,'Licenciado/a en Economía','Analiza la producción, distribución y uso de recursos en la sociedad.'],
            ['Ingeniería Civil','Ingeniería y tecnología','R','I',5,5,'Ingeniero/a Civil','Diseña, construye y supervisa infraestructura, edificaciones y obras de servicio público.'],
            ['Ingeniería Industrial','Ingeniería y tecnología','I','E',5,5,'Ingeniero/a Industrial','Optimiza procesos, recursos, calidad y producción en organizaciones industriales y de servicios.'],
            ['Ingeniería de Sistemas','Ingeniería y tecnología','I','R',4,5,'Ingeniero/a de Sistemas','Diseña soluciones de software, información, infraestructura y transformación digital.'],
            ['Ingeniería Informática','Ingeniería y tecnología','I','R',4,5,'Ingeniero/a Informático/a','Estudia computación, software, datos y sistemas tecnológicos complejos.'],
            ['Ingeniería Electrónica','Ingeniería y tecnología','I','R',5,5,'Ingeniero/a Electrónico/a','Diseña y mantiene sistemas electrónicos, automatización, control y comunicaciones.'],
            ['Ingeniería Eléctrica','Ingeniería y tecnología','R','I',5,5,'Ingeniero/a Eléctrico/a','Estudia la generación, transmisión, distribución y uso de energía eléctrica.'],
            ['Ingeniería Mecánica','Ingeniería y tecnología','R','I',5,5,'Ingeniero/a Mecánico/a','Diseña, analiza y mantiene máquinas, equipos y sistemas mecánicos.'],
            ['Ingeniería Química','Ingeniería y tecnología','I','R',5,5,'Ingeniero/a Químico/a','Diseña procesos para transformar materias primas mediante principios químicos y físicos.'],
            ['Ingeniería Petrolera','Ingeniería y tecnología','R','I',5,5,'Ingeniero/a Petrolero/a','Estudia exploración, extracción y producción técnica de hidrocarburos.'],
            ['Ingeniería Ambiental','Ingeniería y tecnología','I','S',5,5,'Ingeniero/a Ambiental','Desarrolla soluciones para prevenir y gestionar impactos ambientales.'],
            ['Ingeniería Agronómica','Agropecuaria y medio ambiente','R','I',5,5,'Ingeniero/a Agrónomo/a','Aplica ciencia y tecnología a la producción agrícola sostenible.'],
            ['Medicina Veterinaria y Zootecnia','Agropecuaria y medio ambiente','I','R',5,6,'Médico/a Veterinario/a Zootecnista','Estudia la salud animal, producción pecuaria y prevención de enfermedades zoonóticas.'],
            ['Biología','Ciencias naturales y exactas','I','R',5,5,'Licenciado/a en Biología','Estudia los seres vivos, ecosistemas y procesos biológicos.'],
            ['Física','Ciencias naturales y exactas','I','R',4,5,'Licenciado/a en Física','Investiga las leyes fundamentales de la materia, energía y universo.'],
            ['Matemática','Ciencias naturales y exactas','I','C',4,5,'Licenciado/a en Matemática','Estudia estructuras, modelos y razonamiento matemático para resolver problemas.'],
            ['Estadística','Ciencias naturales y exactas','I','C',4,5,'Licenciado/a en Estadística','Transforma datos en evidencia mediante modelos, análisis e inferencia.'],
            ['Química','Ciencias naturales y exactas','I','R',4,5,'Licenciado/a en Ciencias Químicas','Estudia la composición, propiedades y transformaciones de la materia.'],
            ['Arquitectura','Arte, diseño y arquitectura','A','R',5,5,'Arquitecto/a','Diseña espacios habitables integrando técnica, cultura, ambiente y necesidades sociales.'],
            ['Diseño Gráfico','Arte, diseño y arquitectura','A','E',4,5,'Licenciado/a en Diseño Gráfico','Comunica ideas mediante sistemas visuales, identidad, medios digitales y diseño.'],
            ['Artes Plásticas','Arte, diseño y arquitectura','A','R',4,5,'Licenciado/a en Artes Plásticas','Desarrolla expresión y producción artística mediante distintos lenguajes y técnicas.'],
            ['Ciencias de la Educación','Humanidades y educación','S','I',4,5,'Licenciado/a en Ciencias de la Educación','Estudia procesos educativos, currículo, aprendizaje y gestión de instituciones educativas.'],
            ['Filosofía','Humanidades y educación','I','A',4,5,'Licenciado/a en Filosofía','Analiza problemas fundamentales del conocimiento, ética, realidad y pensamiento.'],
            ['Historia','Humanidades y educación','I','A',4,5,'Licenciado/a en Historia','Investiga procesos históricos y su relación con las sociedades actuales.'],
            ['Lingüística e Idiomas','Humanidades y educación','A','I',4,5,'Licenciado/a en Lingüística e Idiomas','Estudia el lenguaje, las lenguas, su enseñanza y sus usos sociales.'],
            ['Literatura','Humanidades y educación','A','I',4,5,'Licenciado/a en Literatura','Analiza y produce discursos literarios en sus contextos culturales e históricos.'],
            ['Turismo','Humanidades y educación','E','S',4,5,'Licenciado/a en Turismo','Planifica y gestiona experiencias, destinos y servicios turísticos sostenibles.'],
        ];

        foreach ($items as [$name,$areaName,$primary,$secondary,$min,$max,$title,$summary]) {
            $area = AcademicArea::where('name', $areaName)->firstOrFail();
            Career::updateOrCreate(['slug' => Str::slug($name)], [
                'academic_area_id' => $area->id,
                'name' => $name,
                'degree_level' => 'Licenciatura',
                'is_traditional' => true,
                'duration_text' => $min === $max ? "$min años aprox." : "$min a $max años aprox.",
                'duration_min_years' => $min,
                'duration_max_years' => $max,
                'reference_title' => $title,
                'riasec_primary' => $primary,
                'riasec_secondary' => $secondary,
                'summary' => $summary,
                'source_url' => 'https://www.umsa.bo/78/-/asset_publisher/DsWbYNfnjuGw/content/lista-de-carreras-umsa/20142',
                'is_active' => true,
            ]);
        }

        Career::where('slug', 'medicina')->update([
            'duration_text' => '6 años (incluye internado rotatorio)',
            'description' => 'Medicina forma profesionales capaces de proteger y recuperar la salud mediante prevención, diagnóstico, tratamiento y rehabilitación. Integra ciencias básicas, formación clínica, investigación, salud pública y una práctica ética centrada en las personas.',
            'study_focus' => 'Durante la formación se estudian ciencias básicas como anatomía, fisiología y bioquímica; posteriormente se abordan áreas clínicas, cirugía, pediatría, ginecología, medicina interna, salud pública y un internado rotatorio.',
            'professional_field' => 'El profesional puede ejercer en hospitales, centros de salud, clínicas, programas de salud pública, investigación, administración sanitaria, docencia y consulta médica, de acuerdo con la normativa y habilitación profesional correspondiente.',
            'economic_scope' => 'En Bolivia contribuye al funcionamiento de servicios públicos y privados de salud. El ingreso y las oportunidades varían según experiencia, especialización, ubicación, empleador y modalidad de ejercicio; la plataforma no presenta promesas salariales.',
            'social_scope' => 'Tiene impacto directo en prevención de enfermedades, atención clínica, educación sanitaria, reducción de riesgos y mejora del bienestar de comunidades urbanas y rurales.',
            'international_scope' => 'El título obtenido en Bolivia puede servir como base para continuar especialidades o ejercer en el exterior, pero cada país exige procesos propios de homologación, idioma, exámenes, residencia o licencia profesional. La acreditación académica puede facilitar movilidad, pero no sustituye estos trámites.',
            'cover_image' => '/images/careers/medicina-estudiantes.png',
            'source_url' => 'https://med.umss.edu.bo/medicina-2/',
            'verified_at' => now(),
        ]);
    }
}
