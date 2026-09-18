<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use App\Models\InstitutionUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaPazInstitutionsSeeder extends Seeder
{
    private const GUIDE = 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run(): void
    {
        $department = Department::where('slug', 'la-paz')->firstOrFail();

        $universities = [
            ['universidad-mayor-de-san-andres','Universidad Mayor de San Andrés','UMSA','Pública','Gratuita','La Paz','Av. Villazón N.º 1995, Plaza del Bicentenario, zona Central','https://www.umsa.bo/', [
                'Ingeniería y tecnología'=>['ingenieria-civil','ingenieria-industrial','ingenieria-electrica','ingenieria-electronica','ingenieria-mecanica','ingenieria-quimica','ingenieria-petrolera','ingenieria-de-sistemas','informatica'],
                'Salud'=>['medicina','enfermeria','odontologia','nutricion-y-dietetica','fisioterapia-y-kinesiologia','bioquimica','quimica-farmaceutica'],
                'Ciencias sociales y humanidades'=>['derecho','ciencia-politica-y-gestion-publica','comunicacion-social','sociologia','trabajo-social','psicologia','ciencias-de-la-educacion','linguistica-e-idiomas','historia','filosofia','literatura'],
                'Economía y administración'=>['economia','administracion-de-empresas','contaduria-publica','turismo'],
                'Ciencias, territorio y diseño'=>['arquitectura','artes-plasticas-y-visuales','diseno-grafico','biologia','fisica','matematicas','quimica','geografia','ingenieria-agronomica','medicina-veterinaria-y-zootecnia'],
            ]],
            ['universidad-publica-de-el-alto','Universidad Pública de El Alto','UPEA','Pública','Gratuita','El Alto','Av. Sucre A, zona Villa Esperanza','https://www.upea.bo/', [
                'Ingeniería y tecnología'=>['ingenieria-de-sistemas','ingenieria-civil','ingenieria-electronica','ingenieria-electrica','ingenieria-industrial','ingenieria-ambiental','arquitectura'],
                'Salud y ciencias agropecuarias'=>['medicina','enfermeria','odontologia','nutricion-y-dietetica','medicina-veterinaria-y-zootecnia','ingenieria-agronomica'],
                'Sociales y económicas'=>['derecho','comunicacion-social','sociologia','trabajo-social','psicologia','ciencias-de-la-educacion','administracion-de-empresas','contaduria-publica','economia','turismo'],
            ]],
            ['universidad-catolica-boliviana-san-pablo-la-paz','Universidad Católica Boliviana San Pablo - Sede La Paz','UCB','Privada','De pago','La Paz','Av. 14 de Septiembre N.º 4807, Obrajes','https://lpz.ucb.edu.bo/', [
                'Ingeniería y diseño'=>['ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-ambiental','ingenieria-mecatronica','arquitectura','diseno-grafico'],
                'Ciencias sociales y empresariales'=>['derecho','psicologia','comunicacion-social','administracion-de-empresas','economia','contaduria-publica','ingenieria-comercial','ingenieria-financiera'],
            ]],
            ['escuela-militar-de-ingenieria-la-paz','Escuela Militar de Ingeniería - Unidad Académica La Paz','EMI','Pública','De pago','La Paz','Av. Arce N.º 2642','https://www.emi.edu.bo/', [
                'Ingeniería'=>['ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-electronica','ingenieria-mecatronica','ingenieria-ambiental','ingenieria-petrolera','ingenieria-comercial'],
            ]],
            ['universidad-privada-boliviana-la-paz','Universidad Privada Boliviana - Campus La Paz','UPB','Privada','De pago','La Paz','Av. Hernando Siles, esquina calle 5, Obrajes','https://www.upb.edu/campus/la-paz', [
                'Ingeniería, arquitectura y negocios'=>['ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-electronica','arquitectura','administracion-de-empresas','economia','ingenieria-comercial','ingenieria-financiera','derecho','diseno-grafico'],
            ]],
            ['universidad-privada-franz-tamayo-la-paz','Universidad Privada Franz Tamayo - La Paz','UNIFRANZ','Privada','De pago','La Paz','Av. Busch N.º 1113, Miraflores','https://unifranz.edu.bo/sedes/la-paz/', [
                'Salud'=>['medicina','odontologia','enfermeria','bioquimica','fisioterapia-y-kinesiologia'],
                'Tecnología, diseño y negocios'=>['ingenieria-de-sistemas','ingenieria-comercial','administracion-de-empresas','contaduria-publica','derecho','psicologia','arquitectura','diseno-grafico'],
            ]],
            ['universidad-privada-del-valle-la-paz','Universidad Privada del Valle - Sede La Paz','UNIVALLE','Privada','De pago','La Paz','Av. Argentina N.º 2083, Miraflores','https://www.univalle.edu/', [
                'Salud e ingeniería'=>['medicina','odontologia','enfermeria','bioquimica','fisioterapia-y-kinesiologia','ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','arquitectura'],
                'Empresariales y sociales'=>['administracion-de-empresas','ingenieria-comercial','derecho','psicologia','gastronomia'],
            ]],
            ['universidad-la-salle-bolivia','Universidad La Salle Bolivia','ULASALLE','Privada','De pago','La Paz','Av. Jorge Carrasco esquina Las Palmas, Bolognia','https://www.ulasalle.edu.bo/', [
                'Tecnología y ciencias sociales'=>['ingenieria-de-sistemas','ingenieria-comercial','administracion-de-empresas','contaduria-publica','derecho','psicologia','ciencias-de-la-educacion'],
            ]],
            ['universidad-salesiana-de-bolivia','Universidad Salesiana de Bolivia','USB','Privada','De pago','La Paz','Av. Chacaltaya N.º 1258, zona Achachicala','https://www.usalesiana.edu.bo/', [
                'Oferta de grado'=>['ciencias-de-la-educacion','psicologia','derecho','contaduria-publica','ingenieria-de-sistemas','educacion-parvularia'],
            ]],
            ['universidad-nuestra-senora-de-la-paz','Universidad Nuestra Señora de La Paz','UNSLP','Privada','De pago','La Paz','Av. Arequipa N.º 8281, La Florida','https://www.unslp.edu.bo/', [
                'Oferta de grado'=>['medicina','odontologia','bioquimica','psicologia','derecho','arquitectura','administracion-de-empresas','ingenieria-comercial','comunicacion-social'],
            ]],
            ['universidad-loyola-la-paz','Universidad Loyola','ULOYOLA','Privada','De pago','La Paz','Av. Busch N.º 1191, Miraflores','https://www.loyola.edu.bo/', [
                'Ingeniería y gestión'=>['ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-electronica','ingenieria-ambiental','arquitectura','administracion-de-empresas','derecho'],
            ]],
            ['universidad-tecnologica-boliviana-la-paz','Universidad Tecnológica Boliviana - La Paz','UTB','Privada','De pago','La Paz','Av. Arce N.º 2618','https://utb.edu.bo/', [
                'Tecnología y empresa'=>['ingenieria-de-sistemas','ingenieria-industrial','ingenieria-electronica','ingenieria-comercial','administracion-de-empresas','contaduria-publica','derecho'],
            ]],
        ];
        foreach ($universities as $data) $this->university($department->id, ...$data);

        $institutes = [
            ['incos-la-paz','Instituto Técnico Comercial Superior de la Nación Tte. Armando de Palacios - INCOS La Paz','La Paz','Calle Federico Zuazo N.º 1673, zona Central',null,'https://www.facebook.com/incoslapazoficial/', ['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','administracion-de-empresas']],
            ['escuela-industrial-superior-pedro-domingo-murillo','Escuela Industrial Superior Pedro Domingo Murillo','La Paz','Av. Chacaltaya N.º 1001, zona Achachicala',null,'https://www.facebook.com/EISPDM/', ['electricidad-industrial','electronica','mecanica-industrial','mecanica-automotriz','quimica-industrial','industria-textil-y-confeccion']],
            ['instituto-tecnico-esae-la-paz','Escuela Superior de Administración de Empresas - ESAE','La Paz','Calle José Saravia N.º 174, zona San Pedro',null,null,['administracion-de-empresas','contaduria-general']],
            ['instituto-tecnologico-superior-isec-la-paz','Instituto Tecnológico Superior ISEC La Paz','La Paz','Calle Murillo N.º 1049, zona Central',null,null,['sistemas-informaticos','contaduria-general','secretariado-ejecutivo','administracion-de-empresas']],
            ['instituto-tecnico-comercial-la-paz','Instituto Técnico Comercial La Paz','La Paz','Calle Yanacocha N.º 695, zona Central',null,null,['contaduria-general','secretariado-ejecutivo','sistemas-informaticos']],
            ['instituto-tecnico-educacion-comercial-americano','Instituto Técnico de Educación Comercial Americano - ITECA','La Paz','Calle Landaeta N.º 423, zona San Pedro','61111322','https://www.iteca.edu.bo/', ['contaduria-general','secretariado-ejecutivo','sistemas-informaticos']],
            ['instituto-tecnologico-puerto-de-mejillones','Instituto Tecnológico Puerto de Mejillones','La Paz','Av. Cívica N.º 100, zona Alto Obrajes',null,null,['mecanica-industrial','electricidad-industrial','electronica','construccion-civil','sistemas-informaticos']],
            ['instituto-tecnologico-bolivia-mar','Instituto Tecnológico Bolivia Mar','El Alto','Av. Bolivia, zona Ciudad Satélite',null,null,['mecanica-automotriz','electricidad-industrial','sistemas-informaticos','contaduria-general','gastronomia']],
            ['centro-formacion-profesional-brasil-bolivia','Centro de Formación Profesional Brasil-Bolivia','El Alto','Av. Cívica, zona Villa Tejada Rectangular',null,null,['mecanica-automotriz','mecanica-industrial','electricidad-industrial','industria-textil-y-confeccion']],
            ['instituto-tecnologico-jacha-omasuyos','Instituto Tecnológico Jach’a Omasuyos','Achacachi','Av. Mariscal Santa Cruz, zona Churubamba',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos','sistemas-informaticos']],
            ['instituto-tecnologico-wiñay-marka','Instituto Tecnológico Superior Wiñay Marka','Achacachi','Comunidad Chijipina Grande',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos']],
            ['instituto-tecnologico-caravani','Instituto Tecnológico Caranavi','Caranavi','Av. Mariscal Santa Cruz, zona Villa Yara',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos','sistemas-informaticos','turismo']],
            ['instituto-tecnologico-apolo','Instituto Tecnológico Apolo - ITA','Apolo','Zona Central, municipio de Apolo',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','turismo','sistemas-informaticos']],
            ['instituto-tecnologico-caquiaviri','Instituto Tecnológico Agropecuario Caquiaviri','Caquiaviri','Zona Central, municipio de Caquiaviri',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','mecanica-automotriz']],
            ['instituto-tecnologico-tuni','Instituto Tecnológico Tuni','Achocalla','Comunidad Tuni, municipio de Achocalla',null,null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos']],
            ['academia-nacional-bellas-artes-hernando-siles','Academia Nacional de Bellas Artes Hernando Siles','La Paz','Calle Rosendo Gutiérrez N.º 323, Sopocachi',null,null,['artes-plasticas-y-visuales']],
            ['conservatorio-plurinacional-musica','Conservatorio Plurinacional de Música','La Paz','Calle Reyes Ortiz N.º 56, zona Central','2441097','https://www.conservatorioplurinacionaldemusica.com/', ['musica']],
        ];
        foreach ($institutes as $data) $this->technical($department->id, ...$data);
    }

    private function university(int $departmentId, string $slug, string $name, string $acronym, string $ownership, string $payment, string $city, string $address, string $website, array $groups): void
    {
        $institution = $this->institution($departmentId, $slug, ['name'=>$name,'acronym'=>$acronym,'institution_type'=>'Universidad','ownership'=>$ownership,'payment_type'=>$payment,'description'=>"Universidad con sede en {$city} y oferta profesional organizada en ".count($groups).' áreas académicas.','cost_notes'=>$payment === 'Gratuita' ? 'Confirmar matrícula, valores y requisitos de admisión vigentes.' : 'Consultar aranceles y modalidades de pago con Admisiones.','schedule_notes'=>'Los horarios varían según carrera, semestre y sede.','city'=>$city,'address'=>$address,'website'=>$website,'source_url'=>$website]);
        foreach ($groups as $position => $careers) {
            $unit = InstitutionUnit::updateOrCreate(['institution_id'=>$institution->id,'slug'=>Str::slug($position)], ['name'=>$position,'unit_type'=>'Área académica','sort_order'=>array_search($position,array_keys($groups))+1,'is_active'=>true]);
            $this->attach($institution,$careers,$unit->id,'Licenciatura','Consultar con la universidad');
        }
    }

    private function technical(int $departmentId, string $slug, string $name, string $city, string $address, ?string $phone, ?string $website, array $careers): void
    {
        $institution = $this->institution($departmentId,$slug,['name'=>$name,'institution_type'=>str_contains($slug,'bellas-artes') || str_contains($slug,'conservatorio') ? 'Instituto artístico' : 'Instituto técnico/tecnológico','ownership'=>'Fiscal o de convenio','payment_type'=>'Gratuita o mixta','description'=>"Institución de formación superior técnica ubicada en {$city}, registrada en el directorio oficial de institutos de La Paz.",'cost_notes'=>'Confirmar valores administrativos, materiales y requisitos con la institución.','schedule_notes'=>'Consultar con la institución.','city'=>$city,'address'=>$address,'phone'=>$phone,'website'=>$website,'source_url'=>$website ?: self::GUIDE]);
        $this->attach($institution,$careers,null,'Técnico Superior','Consultar con la institución');
    }

    private function institution(int $departmentId, string $slug, array $data): Institution
    {
        return Institution::updateOrCreate(['slug'=>$slug],$data+['department_id'=>$departmentId,'is_verified'=>true,'verified_at'=>now(),'is_active'=>true]);
    }

    private function attach(Institution $institution, array $slugs, ?int $unitId, string $level, string $schedule): void
    {
        foreach (Career::whereIn('slug',$slugs)->get() as $career) {
            $institution->careers()->syncWithoutDetaching([$career->id=>['institution_unit_id'=>$unitId,'degree_level'=>$level,'modality'=>'Presencial','schedule'=>$schedule,'duration_text'=>$career->duration_text ?: ($level === 'Técnico Superior' ? '3 años' : 'Consultar plan de estudios'),'labor_demand'=>'Variado','labor_demand_notes'=>null,'is_active'=>true]]);
        }
    }
}
