<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class PandoInstitutionsSeeder extends Seeder
{
    private const GUIDE = 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run(): void
    {
        $department = Department::where('slug', 'pando')->firstOrFail();

        $this->save($department->id, [
            'universidad-amazonica-de-pando','Universidad Amazónica de Pando','UAP','Universidad','Pública','Gratuita','Cobija',
            'Campus Universitario UAP, avenida Las Palmas, barrio 11 de Octubre','https://uap.edu.bo/',
            ['ingenieria-de-sistemas','ingenieria-informatica','ingenieria-civil','ingenieria-industrial','ingenieria-agroforestal','ingenieria-ambiental','medicina-veterinaria-y-zootecnia','medicina','enfermeria','odontologia','bioquimica','derecho','comunicacion-social','trabajo-social','administracion-de-empresas','contaduria-publica','economia','turismo'],
        ]);

        $institutes = [
            ['instituto-tecnico-incos-pando','Instituto Técnico INCOS Pando','INCOS Pando','Instituto técnico/tecnológico','Fiscal','Gratuita','Cobija','Calle Armando Mendoza Herrera esquina Juan Oliveira Barros, zona La Cruz','https://incospando.com/',['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','mecanica-automotriz','gastronomia'],'8423965 / 72817774'],
            ['instituto-tecnologico-superior-silverio-rocha-moya','Instituto Tecnológico Superior Prof. Silverio Rocha Moya','ITSRM','Instituto técnico/tecnológico','Fiscal','Gratuita','Porvenir','Localidad Villa Rojas, km 6 carretera a Filadelfia',null,['ingenieria-agropecuaria'],null],
            ['instituto-tecnologico-amazonico-kemty','Instituto Tecnológico Amazónico Kemty','ITAK','Instituto técnico/tecnológico','Fiscal','Gratuita','San Lorenzo','Municipio de San Lorenzo, Pando',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia'],null],
            ['instituto-tecnologico-bella-flor','Instituto Tecnológico Bella Flor','ITBF','Instituto técnico/tecnológico','Fiscal','Gratuita','Bella Flor','Municipio de Bella Flor, Pando',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia'],null],
            ['instituto-tecnologico-infocal-pando','Instituto Tecnológico INFOCAL Pando','INFOCAL','Instituto técnico/tecnológico','Privada','De pago','Cobija','Final avenida 9 de Febrero, Feria Campesina',null,['gastronomia','mecanica-automotriz','parvularia'], '8422401'],
            ['instituto-tecnico-el-mapajo-pando','Instituto Técnico El Mapajo Pando','MAPAJO','Instituto técnico/tecnológico','Privada','De pago','Cobija','Ciudad de Cobija, municipio Nicolás Suárez',null,['enfermeria'],null],
        ];
        foreach ($institutes as $row) $this->save($department->id, $row);
    }

    private function save(int $departmentId, array $row): void
    {
        [$slug,$name,$acronym,$type,$ownership,$payment,$city,$address,$website,$careerSlugs]=$row;
        $phone=$row[10] ?? null;
        $institution=Institution::updateOrCreate(['slug'=>$slug],[
            'department_id'=>$departmentId,'name'=>$name,'acronym'=>$acronym,'institution_type'=>$type,
            'ownership'=>$ownership,'payment_type'=>$payment,
            'description'=>($type==='Universidad'?'Universidad pública amazónica':'Institución de educación superior técnica')." ubicada en {$city}, con formación vinculada a las necesidades profesionales y productivas de Pando.",
            'cost_notes'=>$payment==='Gratuita'?'Confirmar matrícula, materiales y valores administrativos vigentes.':'Consultar aranceles directamente con la institución.',
            'schedule_notes'=>'Consultar horarios y turnos con la institución.','city'=>$city,'address'=>$address,'phone'=>$phone,
            'website'=>$website,'source_url'=>$website ?: self::GUIDE,'is_verified'=>true,'verified_at'=>now(),'is_active'=>true,
        ]);
        foreach(Career::whereIn('slug',$careerSlugs)->get() as $career) $institution->careers()->syncWithoutDetaching([$career->id=>[
            'degree_level'=>$type==='Universidad'?'Licenciatura':'Técnico Superior','modality'=>'Presencial','schedule'=>'Consultar con la institución',
            'duration_text'=>$career->duration_text ?: ($type==='Universidad'?'Consultar plan de estudios':'3 años'),
            'labor_demand'=>'Variado','labor_demand_notes'=>null,'is_active'=>true,
        ]]);
    }
}
