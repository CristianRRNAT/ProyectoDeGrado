<?php

namespace Database\Seeders;

use App\Models\AcademicArea;
use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AcademicCatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Chuquisaca', 'Sucre'], ['La Paz', 'La Paz'], ['Cochabamba', 'Cochabamba'],
            ['Oruro', 'Oruro'], ['Potosí', 'Potosí'], ['Tarija', 'Tarija'],
            ['Santa Cruz', 'Santa Cruz de la Sierra'], ['Beni', 'Trinidad'], ['Pando', 'Cobija'],
        ] as [$name, $capital]) {
            Department::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'capital' => $capital, 'is_active' => true]);
        }

        $areas = [
            ['Tecnología e informática', 'Soluciones digitales, software, redes y automatización.', '⌘', '#2563EB'],
            ['Administración y economía', 'Gestión de organizaciones, recursos, finanzas y emprendimientos.', '▦', '#14B8A6'],
            ['Construcción y territorio', 'Diseño, medición y ejecución de obras e infraestructura.', '△', '#F59E0B'],
            ['Industria y mecánica', 'Mantenimiento, máquinas, producción y procesos industriales.', '⚙', '#64748B'],
            ['Gastronomía y servicios', 'Alimentos, hospitalidad, atención y experiencias de servicio.', '◇', '#DC6B3F'],
            ['Comunicación y asistencia ejecutiva', 'Comunicación institucional, documentación y apoyo organizacional.', '✦', '#8B5CF6'],
        ];

        foreach ($areas as [$name, $description, $icon, $color]) {
            AcademicArea::updateOrCreate(['slug' => Str::slug($name)], compact('name', 'description', 'icon', 'color') + ['is_active' => true]);
        }

        $department = Department::where('slug', 'cochabamba')->firstOrFail();
        $institution = Institution::updateOrCreate(
            ['slug' => 'instituto-tecnologico-sacaba'],
            [
                'department_id' => $department->id,
                'name' => 'Instituto Tecnológico Sacaba',
                'acronym' => 'ITSA',
                'institution_type' => 'Instituto tecnológico',
                'ownership' => 'Fiscal',
                'payment_type' => 'Gratuita',
                'description' => 'Institución pública de formación técnica que prepara profesionales a nivel Técnico Superior. Su oferta académica es gratuita y dispone de turnos para facilitar el acceso de jóvenes y adultos.',
                'cost_notes' => 'Formación fiscal gratuita; pueden existir gastos administrativos o de materiales que deben consultarse con la institución.',
                'schedule_notes' => 'Mañana y noche',
                'city' => 'Sacaba',
                'address' => 'Av. Circunvalación entre Ismael Céspedes y Granado',
                'phone' => '67598222',
                'email' => 'institutotecnologicoitsa@gmail.com',
                'website' => 'https://itsa.edu.bo/',
                'source_url' => 'https://itsa.edu.bo/',
                'verified_at' => now(),
                'is_verified' => true,
                'is_active' => true,
            ]
        );

        $careers = [
            ['Sistemas Informáticos', 'Tecnología e informática', ['Informática', 'Sistemas', 'Desarrollo de software'], 'I', 'R', 'Forma profesionales capaces de desarrollar sistemas, administrar bases de datos, redes y soluciones tecnológicas.', 'Desarrollo de software, soporte técnico, bases de datos, redes, consultoría y emprendimientos tecnológicos.'],
            ['Informática Industrial', 'Tecnología e informática', ['Automatización industrial', 'Informática aplicada'], 'R', 'I', 'Integra sistemas computacionales, automatización y tecnología aplicada a procesos industriales.', 'Automatización, control industrial, mantenimiento de sistemas computacionales y soluciones tecnológicas para la industria.'],
            ['Administración de Empresas', 'Administración y economía', ['Administración', 'Gestión empresarial'], 'E', 'C', 'Prepara para gestionar organizaciones, recursos, equipos de trabajo y emprendimientos.', 'Administración, comercialización, finanzas, recursos humanos, operaciones y emprendimiento.'],
            ['Contaduría General', 'Administración y economía', ['Contabilidad', 'Contador general'], 'C', 'E', 'Forma profesionales para registrar, analizar y presentar información contable y financiera.', 'Contabilidad, tributación, costos, auditoría, tesorería y asistencia financiera.'],
            ['Secretariado Ejecutivo', 'Comunicación y asistencia ejecutiva', ['Asistencia ejecutiva', 'Secretariado'], 'C', 'S', 'Desarrolla capacidades de gestión documental, comunicación, protocolo y asistencia administrativa.', 'Asistencia ejecutiva, gestión documental, atención institucional y organización de oficinas.'],
            ['Topografía y Geodesia', 'Construcción y territorio', ['Topografía', 'Geodesia'], 'R', 'I', 'Forma profesionales para medir, representar y analizar terrenos mediante métodos topográficos y geodésicos.', 'Levantamientos topográficos, obras civiles, minería, catastro, cartografía y recursos naturales.'],
            ['Construcción Civil', 'Construcción y territorio', ['Construcción', 'Obras civiles'], 'R', 'C', 'Prepara para ejecutar y supervisar procesos constructivos de infraestructura y edificaciones.', 'Supervisión de obras, presupuestos, instalaciones, planificación y ejecución de proyectos constructivos.'],
            ['Mecánica Automotriz', 'Industria y mecánica', ['Mecánica', 'Automotriz'], 'R', 'I', 'Desarrolla capacidades de diagnóstico, mantenimiento y reparación de vehículos a gasolina y diésel.', 'Talleres automotrices, mantenimiento vehicular, diagnóstico técnico, jefatura de taller y emprendimiento.'],
            ['Gastronomía', 'Gastronomía y servicios', ['Artes culinarias', 'Cocina profesional'], 'A', 'R', 'Forma profesionales en cocina, nutrición, planificación de menús, higiene y servicio gastronómico.', 'Restaurantes, hoteles, catering, repostería, industria alimentaria y emprendimientos gastronómicos.'],
        ];

        foreach ($careers as [$name, $areaName, $aliases, $primary, $secondary, $summary, $field]) {
            $area = AcademicArea::where('name', $areaName)->firstOrFail();
            $career = Career::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'academic_area_id' => $area->id,
                    'name' => $name,
                    'alternative_names' => $aliases,
                    'degree_level' => 'Técnico Superior',
                    'riasec_primary' => $primary,
                    'riasec_secondary' => $secondary,
                    'summary' => $summary,
                    'professional_field' => $field,
                    'source_url' => 'https://itsa.edu.bo/',
                    'verified_at' => now(),
                    'is_active' => true,
                ]
            );

            $institution->careers()->syncWithoutDetaching([
                $career->id => ['degree_level' => 'Técnico Superior', 'modality' => 'Presencial', 'schedule' => 'Mañana y noche', 'labor_demand' => 'Variado', 'labor_demand_notes' => null, 'is_active' => true],
            ]);
        }
    }
}
