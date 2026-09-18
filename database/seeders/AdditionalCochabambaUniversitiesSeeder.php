<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdditionalCochabambaUniversitiesSeeder extends Seeder
{
    public function run(): void
    {
        $department = Department::where('slug', 'cochabamba')->firstOrFail();

        $uno = Institution::updateOrCreate(['slug' => 'universidad-nacional-del-oriente-cochabamba'], [
            'department_id' => $department->id,
            'name' => 'Universidad Nacional del Oriente - Cochabamba',
            'acronym' => 'UNO',
            'institution_type' => 'Universidad privada',
            'ownership' => 'Privada',
            'payment_type' => 'De pago',
            'description' => 'Subsede cochabambina de la Universidad Nacional del Oriente. Su oferta publicada se concentra en ciencias de la salud, Derecho y Administración, con formación presencial e infraestructura académica especializada.',
            'cost_notes' => 'Los aranceles y modalidades de beca deben consultarse directamente con la subsede para cada gestión.',
            'schedule_notes' => 'Consultar por carrera y semestre',
            'city' => 'Cochabamba',
            'address' => 'Calle Junín N.º 642, entre José de la Reza y calle La Paz',
            'phone' => '64847741 / 64849322 / 72284488',
            'website' => 'https://www.uno.edu.bo/web/cochabamba',
            'source_url' => 'https://www.uno.edu.bo/web/cochabamba',
            'verified_at' => now(),
            'is_verified' => true,
            'is_active' => true,
        ]);

        $this->attachCareers($uno, [
            ['Medicina', 'Ciencias de la salud', 'I', 'S', 'Licenciatura', 'Según plan de estudios vigente'],
            ['Enfermería', 'Ciencias de la salud', 'S', 'I', 'Licenciatura', 'Según plan de estudios vigente'],
            ['Derecho', 'Derecho y ciencias políticas', 'E', 'S', 'Licenciatura', 'Según plan de estudios vigente'],
            ['Fisioterapia y Kinesiología', 'Ciencias de la salud', 'S', 'R', 'Licenciatura', 'Según plan de estudios vigente'],
            ['Administración y Dirección de Empresas', 'Administración y economía', 'E', 'C', 'Licenciatura', 'Según plan de estudios vigente'],
        ]);

        $unibol = Institution::updateOrCreate(['slug' => 'unibol-quechua-casimiro-huanca'], [
            'department_id' => $department->id,
            'name' => 'UNIBOL Quechua “Casimiro Huanca”',
            'acronym' => 'UNIBOL',
            'institution_type' => 'Universidad indígena pública',
            'ownership' => 'Pública',
            'payment_type' => 'Gratuita',
            'description' => 'Universidad Indígena Boliviana Comunitaria Intercultural Productiva creada en 2008. Integra conocimientos científicos, tecnológicos y saberes quechuas mediante una formación productiva, comunitaria, descolonizadora e intercultural.',
            'cost_notes' => 'La institución publica formación gratuita y beneficios de comedor y residencia sujetos a su convocatoria y requisitos de admisión vigentes.',
            'schedule_notes' => 'Modalidad presencial; consultar horarios con la institución',
            'city' => 'Chimoré',
            'address' => 'Carretera Cochabamba–Santa Cruz, km 190, sector La Jota',
            'phone' => '4-4136832 / 71490172',
            'email' => 'info@unibolquechua.edu.bo',
            'website' => 'https://unibolquechua.edu.bo/',
            'source_url' => 'https://unibolquechua.edu.bo/admision/',
            'verified_at' => now(),
            'is_verified' => true,
            'is_active' => true,
        ]);

        $this->attachCareers($unibol, [
            ['Ingeniería en Agroforestería Comunitaria Ecológica', 'Agropecuaria y medio ambiente', 'R', 'I', 'Ingeniería', '5 años'],
            ['Ingeniería en Transformación de Alimentos', 'Industria y mecánica', 'I', 'R', 'Ingeniería', '5 años'],
            ['Ingeniería en Acuicultura Comunitaria y Gestión de Agua', 'Agropecuaria y medio ambiente', 'R', 'I', 'Ingeniería', '5 años'],
            ['Economía Comunitaria Productiva', 'Administración y economía', 'E', 'C', 'Licenciatura', '5 años'],
        ]);
    }

    private function attachCareers(Institution $institution, array $programs): void
    {
        foreach ($programs as [$name, $areaName, $primary, $secondary, $level, $duration]) {
            $area = AcademicArea::firstOrCreate(['slug' => Str::slug($areaName)], [
                'name' => $areaName,
                'description' => 'Área académica y profesional vinculada con '.$areaName.'.',
                'color' => '#20B486',
                'is_active' => true,
            ]);
            $career = Career::firstOrCreate(['slug' => Str::slug($name)], [
                'academic_area_id' => $area->id,
                'name' => $name,
                'degree_level' => $level,
                'is_traditional' => true,
                'duration_text' => $duration,
                'riasec_primary' => $primary,
                'riasec_secondary' => $secondary,
                'summary' => 'Formación profesional en '.$name.', con conocimientos teóricos, prácticos y aplicación en su campo de especialidad.',
                'description' => 'Esta carrera prepara profesionales para analizar necesidades de su área, aplicar conocimientos especializados y desarrollar soluciones pertinentes en contextos bolivianos.',
                'professional_field' => 'Instituciones públicas y privadas, organizaciones productivas, proyectos especializados, investigación, consultoría y emprendimientos vinculados con la profesión.',
                'is_active' => true,
            ]);
            $institution->careers()->syncWithoutDetaching([$career->id => [
                'degree_level' => $level,
                'modality' => 'Presencial',
                'schedule' => 'Consultar con la institución',
                'duration_text' => $duration,
                'labor_demand' => 'Variado',
                'is_active' => true,
            ]]);
        }
    }
}
