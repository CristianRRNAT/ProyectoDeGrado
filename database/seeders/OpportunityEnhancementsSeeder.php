<?php

namespace Database\Seeders;

use App\Models\LearningVideo;
use App\Models\Opportunity;
use Illuminate\Database\Seeder;

class OpportunityEnhancementsSeeder extends Seeder
{
    public function run(): void
    {
        $checked = now();
        $items = [
            ['slug'=>'ingles-cba-cochabamba','type'=>'course','title'=>'Cursos de inglés en Cochabamba','provider'=>'Centro Boliviano Americano — Cochabamba','description'=>'Programa de inglés comunicativo que desarrolla comprensión auditiva, conversación, escritura y lectura, con opciones estándar, regulares e intensivas para diferentes edades.','modality'=>'Presencial; consultar opciones virtuales','cost_type'=>'paid','duration'=>'Según programa y nivel','audience'=>'Niños, jóvenes y adultos','requirements'=>'Completar el proceso de inscripción y confirmar el nivel de ingreso, horario y cupo disponible.','application_process'=>'Revisar el portal de inscripciones del CBA Cochabamba o comunicarse con la sede para confirmar la fecha de inicio, modalidad y precio del periodo.','contact'=>'422-1288 / 422-2518 / cba@cbacoch.org','location'=>'Calle 25 de Mayo N.º 0365, Cochabamba','availability_status'=>'open','official_url'=>'https://cbacoch.org/','image_url'=>'https://cbacoch.org/wp-content/uploads/2018/09/logo-cba.png'],
            ['slug'=>'talleres-casa-juventud-cochabamba','type'=>'course','title'=>'Talleres gratuitos para jóvenes','provider'=>'Casa Municipal de la Juventud de Cochabamba','description'=>'Espacio municipal que habitualmente desarrolla talleres de danza, canto, instrumentos musicales, robótica, computación, diseño gráfico, electricidad domiciliaria, teatro y cinematografía. La programación cambia por gestión y temporada.','modality'=>'Presencial','cost_type'=>'free','duration'=>'Depende del taller y la convocatoria','audience'=>'Adolescentes y jóvenes; las edades dependen de cada convocatoria','requirements'=>'Consultar la convocatoria vigente. En ediciones anteriores se solicitaron fotocopias de cédula de identidad y fólder.','application_process'=>'Acudir o contactar a la Casa Municipal de la Juventud para preguntar qué talleres tienen inscripciones abiertas. No asumir que todos los cursos están disponibles al mismo tiempo.','contact'=>'Consultar presencialmente o mediante los canales municipales','location'=>'Calle 16 de Julio entre Sucre y Jordán N.º 345, Cochabamba','availability_status'=>'consult','official_url'=>'https://www.govserv.org/BO/Cochabamba/873620522669146/Casa-Municipal-De-La-Juventud-De-Cochabamba','image_url'=>null],
            ['slug'=>'ingles-jovenes-adultos-cba','type'=>'course','title'=>'Programa de inglés para jóvenes y adultos','provider'=>'Centro Boliviano Americano — Santa Cruz','description'=>'Formación progresiva en inglés con programas intensivo, interdiario, dúo y sabatino, además de preparación TOEFL.','modality'=>'Presencial, híbrida o virtual','cost_type'=>'paid','duration'=>'Según programa y nivel','audience'=>'Jóvenes y adultos desde los 17 años','requirements'=>'Registro como estudiante nuevo y confirmación del nivel y cupo disponible.','application_process'=>'Completar el formulario de alumno nuevo y confirmar con un asesor el periodo, horario, modalidad y precio vigentes.','contact'=>'Atención mediante el chat oficial del CBA','location'=>'Santa Cruz de la Sierra y modalidad virtual','availability_status'=>'open','official_url'=>'https://www.cba.com.bo/programa-de-ingles-para-jovenes-y-adultos/','image_url'=>'https://www.cba.com.bo/wp-content/uploads/2020/06/Logo-Perfil-Zoom_CBA-ROJO.jpg'],
            ['slug'=>'reparacion-celulares-cepro','type'=>'course','title'=>'Reparación y mantenimiento de celulares','provider'=>'Instituto Tecnológico CEPRO','description'=>'Curso práctico orientado al diagnóstico, mantenimiento y reparación de dispositivos móviles. CEPRO debe confirmar el grupo actualmente habilitado.','modality'=>'Presencial','cost_type'=>'consult','duration'=>'Consultar programa vigente','audience'=>'Jóvenes y adultos interesados en soporte técnico','requirements'=>'Consultar edad mínima, herramientas y conocimientos previos.','application_process'=>'Contactar directamente a CEPRO y solicitar la ficha vigente del curso, costo, horario y tipo de certificación antes de reservar.','contact'=>'76438829 / 4 4457745 / info@institutocepro.edu.bo','location'=>'Av. San Martín #474, Cochabamba; subsede en Quillacollo','availability_status'=>'consult','official_url'=>'https://www.institutocepro.edu.bo/contact','image_url'=>null],
            ['slug'=>'modelaje-profesional-merak','type'=>'course','title'=>'Curso de modelaje profesional','provider'=>'Merak — Escuela de Modelos','description'=>'Formación en pasarela, poses, imagen y expresión. La edición publicada inició en agosto de 2026; corresponde consultar el siguiente grupo.','modality'=>'Presencial','cost_type'=>'consult','duration'=>'Consultar próxima edición','audience'=>'Personas interesadas en modelaje e imagen','requirements'=>'Consultar edad, cupos y condiciones directamente con la academia.','application_process'=>'Solicitar información del próximo inicio y verificar costo, horarios, contenidos y certificación antes de pagar.','contact'=>'Contacto mediante sus canales publicados','location'=>'Calle La Paz esq. Valdivieso, Edif. Roch, piso 3, Cochabamba','availability_status'=>'consult','official_url'=>'https://www.schoolandcollegelistings.com/BO/Cochabamba/102146248940157/Merak---Escuela-de-modelos','image_url'=>null],
            ['slug'=>'tecnicas-culinarias-corporacion-tunari','type'=>'course','title'=>'Técnicas culinarias en gastronomía','provider'=>'Corporación Tunari','description'=>'Formación práctica en cocina nacional e internacional, preparación de platos y postres, orientada también al autoempleo.','modality'=>'Presencial','cost_type'=>'consult','duration'=>'Consultar plan vigente','audience'=>'Jóvenes y adultos','requirements'=>'Confirmar edad, materiales, costo y certificación.','application_process'=>'Solicitar a la institución la información actualizada de inscripciones, horarios y costo total.','contact'=>'Consultar en la publicación institucional','location'=>'Santiváñez #169, Cochabamba','availability_status'=>'consult','official_url'=>'https://www.schoolandcollegelistings.com/BO/Cochabamba/575174266160066/Corporaci%C3%B3n-Tunari','image_url'=>null],
        ];

        foreach ($items as $item) {
            Opportunity::updateOrCreate(['slug'=>$item['slug']], $item + ['cost_amount'=>null,'currency'=>'BOB','start_date'=>null,'deadline'=>null,'promotion_text'=>null,'verified_at'=>$checked,'is_verified'=>true,'is_active'=>true]);
        }

        Opportunity::where('slug', 'cursos-tecnicos-infocal-2026')->update(['image_url'=>'https://www.infocalcbba.edu.bo/wp-content/uploads/2019/04/logo.png']);

        LearningVideo::whereIn('youtube_id', ['mZiAVJmE0gQ', 'R7QqjK5Zl8M'])->delete();

        foreach ([
            ['8yOXb8-Pc3k','Conceptos básicos de electrónica para reparar celulares','i2C Tech','Reparación de celulares','course'],
            ['BdKroh5GUJ0','Ejercicio de técnica y recuperación vocal','Superior Singing Method','Canto profesional','course'],
            ['KFSfBIFyr-w','Conversación sobre formación profesional en danza','Mentalidades','Danza profesional','course'],
            ['2LiMrDhR_9U','Modelaje de pasarela: rutina básica','Johanna Modelos','Modelaje','course'],
            ['ZcFv2jyu7qg','Cómo empezar a crear contenido con bajo presupuesto','Timeless Lessons','Creación de contenido','course'],
            ['PHkzsZZPjqw','Capacitaciones externas de la Aduana Nacional','Aduana Informa — Aduana Nacional de Bolivia','Comercio exterior','training'],
        ] as [$id,$title,$channel,$area,$section]) {
            LearningVideo::updateOrCreate(['youtube_id'=>$id], ['title'=>$title,'channel'=>$channel,'career_area'=>$area,'section_type'=>$section,'description'=>'Contenido introductorio para explorar esta área antes de elegir una formación.','is_active'=>true]);
        }
    }
}
