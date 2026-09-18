<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\CareerSource;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeacherTrainingSeeder extends Seeder
{
    private const SOURCE = 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2025/resoluciones/CONVOCATORIA_PBLICA_N_001_2025.pdf';

    public function run(): void
    {
        $area = AcademicArea::where('name', 'Humanidades y educación')->firstOrFail();
        $career = Career::updateOrCreate(['slug' => 'formacion-de-maestros'], [
                'academic_area_id' => $area->id,
                'name' => 'Formación de Maestros',
                'alternative_names' => ['Profesor', 'Profesora', 'Maestro', 'Maestra', 'Docencia', 'Formación docente', 'Profesor de primaria', 'Profesor de secundaria'],
                'degree_level' => 'Licenciatura',
                'is_traditional' => true,
                'duration_text' => '5 años',
                'duration_min_years' => 5,
                'duration_max_years' => 5,
                'reference_title' => 'Licenciado/a Maestro/a en la especialidad cursada',
                'riasec_primary' => 'S',
                'riasec_secondary' => 'A',
                'summary' => 'Forma maestras y maestros para Educación Inicial, Primaria, Secundaria y áreas especializadas del Sistema Educativo Plurinacional.',
                'source_url' => self::SOURCE,
                'verified_at' => now(),
                'is_active' => true,
        ]);
        CareerSource::updateOrCreate(['career_id' => $career->id, 'source_url' => self::SOURCE], [
                'source_name' => 'Ministerio de Educación — Admisión ESFM/UA 2026',
                'source_year' => 2026,
                'notes' => 'Convocatoria oficial con especialidades y plazas por ESFM y Unidad Académica.',
                'checked_at' => now(),
        ]);

        $obsolete = Career::whereIn('slug', ['formacion-de-maestros-en-educacion-primaria', 'formacion-de-maestros-en-ingles', 'formacion-de-maestros-en-educacion-musical'])->get();
        foreach ($obsolete as $oldCareer) {
            $oldCareer->institutions()->detach();
            $oldCareer->delete();
        }

        $department = Department::where('slug', 'cochabamba')->firstOrFail();
        $institution = Institution::updateOrCreate(['slug' => 'esfm-simon-rodriguez-cochabamba'], [
            'department_id' => $department->id,
            'name' => 'Escuela Superior de Formación de Maestras y Maestros Simón Rodríguez',
            'acronym' => 'ESFM Simón Rodríguez',
            'institution_type' => 'Escuela Superior de Formación de Maestros',
            'ownership' => 'Fiscal',
            'payment_type' => 'Gratuita',
            'description' => 'Institución fiscal dependiente del Ministerio de Educación dedicada a la formación inicial de maestras y maestros con grado académico de Licenciatura. Cuenta con una sede principal y unidades académicas en distintos municipios de Cochabamba.',
            'is_single_program' => true,
            'specialty_areas' => [
                'Educación Inicial en Familia Comunitaria',
                'Educación Primaria Comunitaria Vocacional',
                'Ciencias Sociales',
                'Matemática',
                'Ciencias Naturales: Biología y Geografía',
                'Ciencias Naturales: Física y Química',
                'Comunicación y Lenguajes: Lengua Castellana',
                'Comunicación y Lenguajes: Lengua Extranjera (Inglés)',
                'Educación Musical',
                'Educación Física y Deportes',
                'Educación Especial para Personas con Discapacidad',
                'Transformación de Alimentos y Gastronomía',
            ],
            'cost_notes' => 'La formación es fiscal y de acceso gratuito. El proceso de admisión puede establecer un derecho de postulación y otros valores administrativos según la convocatoria vigente.',
            'schedule_notes' => 'Consultar horarios, calendario y modalidad directamente con la ESFM o la Unidad Académica elegida.',
            'city' => 'Quillacollo',
            'address' => 'ESFM Simón Rodríguez, Quillacollo',
            'website' => 'https://www.minedu.gob.bo/',
            'source_url' => self::SOURCE,
            'campuses' => [
                ['name' => 'Sede principal ESFM Simón Rodríguez', 'city' => 'Quillacollo', 'address' => 'ESFM Simón Rodríguez, Quillacollo, Cochabamba', 'programs' => ['Educación Primaria Comunitaria Vocacional']],
                ['name' => 'Unidad Académica Cercado', 'city' => 'Cochabamba', 'address' => 'Unidad Académica Cercado ESFM Simón Rodríguez, Cochabamba', 'programs' => ['Comunicación y Lenguajes: Lengua Extranjera (Inglés)']],
                ['name' => 'Unidad Académica Sacaba', 'city' => 'Sacaba', 'address' => 'Unidad Académica Sacaba ESFM Simón Rodríguez, Cochabamba', 'programs' => ['Educación Primaria Comunitaria Vocacional']],
                ['name' => 'Unidad Académica Tarata', 'city' => 'Tarata', 'address' => 'Unidad Académica Tarata ESFM Simón Rodríguez, Cochabamba', 'programs' => ['Educación Musical']],
                ['name' => 'Unidad Académica Villa Tunari', 'city' => 'Villa Tunari', 'address' => 'Unidad Académica Villa Tunari ESFM Simón Rodríguez, Cochabamba', 'programs' => ['Educación Primaria Comunitaria Vocacional']],
                ['name' => 'ESFM Puerto Rico', 'city' => 'Puerto Rico, Pando', 'address' => 'ESFM Puerto Rico, Pando', 'programs' => ['Lengua Castellana', 'Primaria']],
                ['name' => 'UA Cobija', 'city' => 'Cobija, Pando', 'address' => 'Unidad Académica Cobija ESFM Puerto Rico, Pando', 'programs' => ['Matemática']],
                ['name' => 'UA Filadelfia', 'city' => 'Filadelfia, Pando', 'address' => 'Unidad Académica Filadelfia ESFM Puerto Rico, Pando', 'programs' => ['Matemática']],
                ['name' => 'ESFM Clara Parada de Pinto', 'city' => 'Trinidad, Beni', 'address' => 'ESFM Clara Parada de Pinto, Trinidad, Beni', 'programs' => ['Biología-Geografía', 'Ciencias Sociales', 'Primaria']],
                ['name' => 'ESFM Riberalta', 'city' => 'Riberalta, Beni', 'address' => 'ESFM Riberalta, Beni', 'programs' => ['Biología-Geografía', 'Física-Química', 'Ciencias Sociales']],
                ['name' => 'UA Multiétnica Lorenza Congo', 'city' => 'Beni', 'address' => 'Unidad Académica Lorenza Congo, Beni', 'programs' => ['Inglés']],
                ['name' => 'ESFM Mariscal Sucre', 'city' => 'Sucre, Chuquisaca', 'address' => 'ESFM Mariscal Sucre, Sucre, Bolivia', 'programs' => ['Primaria']],
                ['name' => 'ESFM Simón Bolívar - Cororo', 'city' => 'Cororo, Chuquisaca', 'address' => 'ESFM Simón Bolívar, Cororo, Chuquisaca', 'programs' => ['Primaria']],
                ['name' => 'ESFM Franz Tamayo', 'city' => 'Villa Serrano, Chuquisaca', 'address' => 'ESFM Franz Tamayo, Villa Serrano, Chuquisaca', 'programs' => ['Transformación de Alimentos y Gastronomía']],
                ['name' => 'ESFM Ismael Montes', 'city' => 'Vacas, Cochabamba', 'address' => 'ESFM Ismael Montes, Vacas, Cochabamba', 'programs' => ['Primaria']],
                ['name' => 'ESFM Manuel Ascencio Villarroel', 'city' => 'Paracaya, Cochabamba', 'address' => 'ESFM Manuel Ascencio Villarroel, Paracaya, Cochabamba', 'programs' => ['Primaria']],
                ['name' => 'ESFM Simón Bolívar', 'city' => 'La Paz', 'address' => 'ESFM Simón Bolívar, La Paz, Bolivia', 'programs' => ['Ciencias Sociales', 'Inglés', 'Primaria', 'Matemática']],
                ['name' => 'ESFM Warisata', 'city' => 'Warisata, La Paz', 'address' => 'ESFM Warisata, La Paz, Bolivia', 'programs' => ['Inicial', 'Primaria']],
                ['name' => 'ESFM Santiago de Huata', 'city' => 'Santiago de Huata, La Paz', 'address' => 'ESFM Santiago de Huata, La Paz', 'programs' => ['Inicial', 'Primaria']],
                ['name' => 'ESFM Mcal. Andrés de Santa Cruz y Calahumana', 'city' => 'La Paz', 'address' => 'ESFM Mariscal Andrés de Santa Cruz y Calahumana, La Paz', 'programs' => ['Primaria']],
                ['name' => 'ESFM de Educación Física Antonio José de Sucre', 'city' => 'La Paz', 'address' => 'ESFM Educación Física Antonio José de Sucre, La Paz', 'programs' => ['Educación Física y Deportes']],
                ['name' => 'ESFM Tecnológico y Humanístico El Alto', 'city' => 'El Alto, La Paz', 'address' => 'ESFM Tecnológico Humanístico El Alto, Bolivia', 'programs' => ['Inglés', 'Inicial', 'Primaria']],
                ['name' => 'ESFM Villa Aroma', 'city' => 'Villa Aroma, La Paz', 'address' => 'ESFM Villa Aroma, La Paz', 'programs' => ['Inicial', 'Primaria']],
                ['name' => 'UA Ancocagua', 'city' => 'Ancocagua, La Paz', 'address' => 'Unidad Académica Ancocagua ESFM, La Paz', 'programs' => ['Biología-Geografía']],
                ['name' => 'UA Caranavi', 'city' => 'Caranavi, La Paz', 'address' => 'Unidad Académica Caranavi ESFM Simón Bolívar, La Paz', 'programs' => ['Inicial']],
                ['name' => 'UA Corpa', 'city' => 'Corpa, La Paz', 'address' => 'Unidad Académica Corpa ESFM, La Paz', 'programs' => ['Física-Química']],
                ['name' => 'ESFM Ángel Mendoza Justiniano', 'city' => 'Oruro', 'address' => 'ESFM Ángel Mendoza Justiniano, Oruro, Bolivia', 'programs' => ['Biología-Geografía', 'Ciencias Sociales']],
                ['name' => 'ESFM Caracollo', 'city' => 'Caracollo, Oruro', 'address' => 'ESFM Caracollo, Oruro', 'programs' => ['Primaria', 'Educación Especial']],
                ['name' => 'UA Corque', 'city' => 'Corque, Oruro', 'address' => 'Unidad Académica Corque ESFM, Oruro', 'programs' => ['Inicial']],
                ['name' => 'UA Machacamarca', 'city' => 'Machacamarca, Oruro', 'address' => 'Unidad Académica Machacamarca ESFM, Oruro', 'programs' => ['Educación Física']],
                ['name' => 'UA Pampa Aullagas', 'city' => 'Pampa Aullagas, Oruro', 'address' => 'Unidad Académica Pampa Aullagas ESFM, Oruro', 'programs' => ['Educación Musical']],
                ['name' => 'ESFM Eduardo Avaroa', 'city' => 'Potosí', 'address' => 'ESFM Eduardo Avaroa, Potosí, Bolivia', 'programs' => ['Primaria']],
                ['name' => 'ESFM Franz Tamayo - Potosí', 'city' => 'Potosí', 'address' => 'ESFM Franz Tamayo, Potosí, Bolivia', 'programs' => ['Inicial']],
                ['name' => 'ESFM José David Berríos', 'city' => 'Potosí', 'address' => 'ESFM José David Berríos, Potosí, Bolivia', 'programs' => ['Primaria']],
                ['name' => 'ESFM Mcal. Andrés de Santa Cruz', 'city' => 'Potosí', 'address' => 'ESFM Mariscal Andrés de Santa Cruz, Potosí', 'programs' => ['Primaria']],
                ['name' => 'UA Atocha', 'city' => 'Atocha, Potosí', 'address' => 'Unidad Académica Atocha ESFM, Potosí', 'programs' => ['Inicial']],
                ['name' => 'UA San Luis de Sacaca', 'city' => 'Sacaca, Potosí', 'address' => 'Unidad Académica San Luis de Sacaca ESFM, Potosí', 'programs' => ['Inicial']],
                ['name' => 'UA San Pedro de Quemes', 'city' => 'San Pedro de Quemes, Potosí', 'address' => 'Unidad Académica San Pedro de Quemes ESFM, Potosí', 'programs' => ['Primaria']],
                ['name' => 'ESFM Enrique Finot', 'city' => 'Santa Cruz de la Sierra', 'address' => 'ESFM Enrique Finot, Santa Cruz, Bolivia', 'programs' => ['Ciencias Sociales', 'Inglés', 'Matemática']],
                ['name' => 'ESFM Multiétnica Indígena de Concepción', 'city' => 'Concepción, Santa Cruz', 'address' => 'ESFM Multiétnica Indígena de Concepción, Santa Cruz', 'programs' => ['Ciencias Sociales', 'Inglés', 'Primaria']],
                ['name' => 'ESFM Pluriétnica del Oriente y Chaco', 'city' => 'Camiri, Santa Cruz', 'address' => 'ESFM Pluriétnica del Oriente y Chaco, Camiri', 'programs' => ['Inglés', 'Primaria', 'Matemática']],
                ['name' => 'ESFM Rafael Chávez Ortiz', 'city' => 'Portachuelo, Santa Cruz', 'address' => 'ESFM Rafael Chávez Ortiz, Portachuelo, Santa Cruz', 'programs' => ['Ciencias Sociales', 'Inglés', 'Primaria']],
                ['name' => 'UA Charagua', 'city' => 'Charagua, Santa Cruz', 'address' => 'Unidad Académica Charagua ESFM, Santa Cruz', 'programs' => ['Inglés', 'Matemática']],
                ['name' => 'UA San Julián', 'city' => 'San Julián, Santa Cruz', 'address' => 'Unidad Académica San Julián ESFM, Santa Cruz', 'programs' => ['Inglés', 'Primaria']],
                ['name' => 'UA Vallegrande', 'city' => 'Vallegrande, Santa Cruz', 'address' => 'Unidad Académica Vallegrande ESFM Enrique Finot, Santa Cruz', 'programs' => ['Inglés', 'Primaria']],
                ['name' => 'ESFM Juan Misael Saracho', 'city' => 'Canasmoro, Tarija', 'address' => 'ESFM Juan Misael Saracho, Canasmoro, Tarija', 'programs' => ['Primaria']],
                ['name' => 'UA Tarija', 'city' => 'Tarija', 'address' => 'Unidad Académica Tarija ESFM Juan Misael Saracho', 'programs' => ['Inicial']],
                ['name' => 'UA Gran Chaco', 'city' => 'Yacuiba, Tarija', 'address' => 'Unidad Académica Gran Chaco ESFM, Yacuiba, Tarija', 'programs' => ['Inicial']],
            ],
            'is_verified' => true,
            'verified_at' => now(),
            'is_active' => true,
        ]);

        // Las sedes quedan disponibles para el mapa JavaScript con múltiples marcadores.

        $institution->careers()->syncWithoutDetaching([$career->id => [
                'degree_level' => 'Licenciatura', 'modality' => 'Presencial',
                'schedule' => 'Mañana y noche', 'academic_regime' => 'Semestral',
                'duration_text' => '5 años aprox.',
                'labor_demand' => 'Variado', 'labor_demand_notes' => null,
                'admission_requirements' => 'Ingreso mediante el proceso oficial de admisión a ESFM/UA.', 'is_active' => true,
        ]]);
    }
}
