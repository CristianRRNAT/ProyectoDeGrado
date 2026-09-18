<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class BeniInstitutionsSeeder extends Seeder
{
    private const GUIDE='https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run(): void
    {
        $department=Department::where('slug','beni')->firstOrFail();
        $rows=[
            ['universidad-autonoma-del-beni-jose-ballivian','Universidad Autónoma del Beni José Ballivián','UABJB','Universidad','Pública','Gratuita','Trinidad','Av. 6 de Agosto N.º 61, edificio Antonio Vaca Díez, zona Central','https://www.uabjb.edu.bo/',['medicina','enfermeria','odontologia','medicina-veterinaria-y-zootecnia','ingenieria-agronomica','ingenieria-civil','ingenieria-de-sistemas','derecho','comunicacion-social','administracion-de-empresas','contaduria-publica','economia','turismo']],
            ['universidad-privada-del-valle-trinidad','Universidad Privada del Valle - Sede Trinidad','UNIVALLE','Universidad','Privada','De pago','Trinidad','Av. 6 de Agosto, ciudad de Trinidad','https://www.univalle.edu/',['medicina','odontologia','enfermeria','bioquimica','fisioterapia-y-kinesiologia','ingenieria-de-sistemas','administracion-de-empresas','derecho']],
            ['instituto-tecnico-incos-beni','Instituto Técnico INCOS Beni','INCOS','Instituto técnico/tecnológico','Fiscal','Gratuita','Trinidad','Av. 18 de Noviembre, zona Central',null,['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','administracion-de-empresas','gastronomia']],
            ['instituto-tecnologico-superior-amazonia-itsa','Instituto Tecnológico Superior de la Amazonía ITSA','ITSA','Instituto técnico/tecnológico','Fiscal','Gratuita','Riberalta','Comunidad Las Palmeras, Riberalta','https://www.itsariberalta.edu.bo/',['sistemas-informaticos','veterinaria-y-zootecnia','contaduria-general','administracion-de-empresas','secretariado-ejecutivo','ingenieria-agropecuaria','turismo','industria-de-alimentos','mecanica-automotriz','electricidad-industrial','piscicultura'],'69021318 / 3222931'],
            ['instituto-tecnico-incos-guayaramerin','Instituto Técnico INCOS Guayaramerín','INCOS','Instituto técnico/tecnológico','Fiscal','Gratuita','Guayaramerín','Zona Central, ciudad de Guayaramerín',null,['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','administracion-de-empresas','gastronomia']],
            ['instituto-tecnico-incos-santa-ana','Instituto Técnico INCOS Santa Ana','INCOS','Instituto técnico/tecnológico','Fiscal','Gratuita','Santa Ana del Yacuma','Zona Central, Santa Ana del Yacuma',null,['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','administracion-de-empresas']],
            ['instituto-tecnologico-kateri-tekawitha','Instituto Tecnológico Kateri Tekawitha Fe y Alegría','ITKT','Instituto técnico/tecnológico','De convenio','Mixta','San Ignacio de Moxos','Zona Central, San Ignacio de Moxos',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','turismo','industria-de-alimentos']],
            ['instituto-tecnologico-jose-castillo-fe-alegria','Instituto Tecnológico Superior José Castillo Fe y Alegría','ITSJC','Instituto técnico/tecnológico','De convenio','Mixta','Trinidad','Ciudad de Trinidad, provincia Cercado','https://www.superiorjosecastillo.com/',['sistemas-informaticos','electricidad-industrial','gastronomia','contaduria-general','secretariado-ejecutivo']],
            ['instituto-tecnico-computacion-riberalta','Instituto Técnico en Computación ITC Riberalta','ITC','Instituto técnico/tecnológico','Privada','De pago','Riberalta','Av. Verda Lago esquina Av. Sonneschein s/n, barrio 25 de Marzo','https://www.itcriberalta.edu.bo/',['sistemas-informaticos'],'75240502'],
            ['instituto-tecnico-cet-beni','Instituto Técnico CET Beni','CET-BENI','Instituto técnico/tecnológico','De convenio','Mixta','Trinidad','Ciudad de Trinidad, Beni',null,['enfermeria','sistemas-informaticos','contaduria-general']],
            ['escuela-tecnica-salud-trinidad','Escuela Técnica de Salud Trinidad','ETS','Instituto técnico/tecnológico','Fiscal','Gratuita','Trinidad','Zona hospitalaria, ciudad de Trinidad',null,['enfermeria','laboratorio-clinico']],
            ['escuela-tecnica-salud-riberalta','Escuela Técnica de Salud Riberalta','ETS','Instituto técnico/tecnológico','Fiscal','Gratuita','Riberalta','Zona hospitalaria, ciudad de Riberalta',null,['enfermeria','laboratorio-clinico']],
        ];
        foreach($rows as $row)$this->save($department->id,$row);
    }

    private function save(int $departmentId,array $row):void
    {
        [$slug,$name,$acronym,$type,$ownership,$payment,$city,$address,$website,$slugs]=$row;
        $phone=$row[10]??null;
        $institution=Institution::updateOrCreate(['slug'=>$slug],['department_id'=>$departmentId,'name'=>$name,'acronym'=>$acronym,'institution_type'=>$type,'ownership'=>$ownership,'payment_type'=>$payment,'description'=>($type==='Universidad'?'Universidad':'Institución de educación superior técnica')." con presencia en {$city} y oferta académica orientada al desarrollo del Beni.",'cost_notes'=>$payment==='Gratuita'?'Confirmar valores administrativos, matrícula y materiales.':'Consultar aranceles con la institución.','schedule_notes'=>'Consultar horarios y turnos vigentes.','city'=>$city,'address'=>$address,'phone'=>$phone,'website'=>$website,'source_url'=>$website?:self::GUIDE,'is_verified'=>true,'verified_at'=>now(),'is_active'=>true]);
        foreach(Career::whereIn('slug',$slugs)->get() as $career)$institution->careers()->syncWithoutDetaching([$career->id=>['degree_level'=>$type==='Universidad'?'Licenciatura':'Técnico Superior','modality'=>'Presencial','schedule'=>'Consultar con la institución','duration_text'=>$career->duration_text?:($type==='Universidad'?'Consultar plan de estudios':'3 años'),'labor_demand'=>'Variado','labor_demand_notes'=>null,'is_active'=>true]]);
    }
}
