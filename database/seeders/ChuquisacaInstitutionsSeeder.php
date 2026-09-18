<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class ChuquisacaInstitutionsSeeder extends Seeder
{
    private const GUIDE='https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run():void
    {
        $department=Department::where('slug','chuquisaca')->firstOrFail();
        $rows=[
            ['universidad-san-francisco-xavier-chuquisaca','Universidad Mayor, Real y Pontificia de San Francisco Xavier de Chuquisaca','USFX','Universidad','Pública','Gratuita','Sucre','Calle Junín esquina Estudiantes N.º 692','https://usfx.bo/',['medicina','enfermeria','odontologia','bioquimica','quimica-farmaceutica','ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-electronica','ingenieria-petrolera','ingenieria-agronomica','arquitectura','diseno-de-interiores','derecho','psicologia','comunicacion-social','sociologia','trabajo-social','historia','turismo','economia','administracion-de-empresas','contaduria-publica','ingenieria-comercial']],
            ['universidad-privada-domingo-savio-sucre','Universidad Privada Domingo Savio - Sede Sucre','UPDS','Universidad','Privada','De pago','Sucre','Calle Cacique Titu N.º 175, zona Villa Charcas','https://www.upds.edu.bo/sede/sucre/',['ingenieria-de-sistemas','ingenieria-industrial','ingenieria-civil','arquitectura','administracion-de-empresas','contaduria-publica','ingenieria-comercial','derecho','psicologia','comunicacion-social']],
            ['instituto-tecnico-superior-educacion-comercial-itsec-sucre','Instituto Técnico Superior de Educación Comercial ITSEC Sucre','ITSEC','Instituto técnico/tecnológico','Fiscal','Gratuita','Sucre','Zona Central, ciudad de Sucre',null,['contaduria-general','secretariado-ejecutivo','sistemas-informaticos','administracion-de-empresas']],
            ['instituto-tecnologico-aurora-rossells','Instituto Tecnológico Aurora Rossells de Fe y Alegría','ITAR','Instituto técnico/tecnológico','De convenio','Mixta','Sucre','Calle Azurduy N.º 57','https://www.facebook.com/aurorarossellsfya/',['secretariado-ejecutivo','contaduria-general','parvularia','gastronomia'],'6461522'],
            ['instituto-tecnologico-superior-tecba-sucre','Instituto Tecnológico Boliviano Alemán TECBA - Sucre','TECBA','Instituto técnico/tecnológico','Privada','De pago','Sucre','Calle Luis Paz Arce N.º 202, av. Hernando Siles esquina parque Bolívar','https://www.tecbasucre.com/',['administracion-de-empresas','contaduria-general','sistemas-informaticos','arquitectura','diseno-grafico','comunicacion-social'],'6453697 / 76123189'],
            ['instituto-politécnico-tomas-katari','Instituto Politécnico Tomás Katari','IPTK','Instituto técnico/tecnológico','De convenio','Mixta','Sucre','Calle Ovidio Céspedes N.º 413, zona San José','https://iptk.org.bo/',['enfermeria','ingenieria-agropecuaria','industria-de-alimentos','sistemas-informaticos']],
            ['instituto-tecnologico-superior-agropecuario-industrial-huacareta','Instituto Tecnológico Superior Agropecuario Industrial Huacareta','ITSA-H','Instituto técnico/tecnológico','Fiscal','Gratuita','Huacareta','Zona Central, municipio de Huacareta',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos']],
            ['instituto-tecnologico-monteagudo','Instituto Tecnológico Superior Monteagudo','ITSM','Instituto técnico/tecnológico','Fiscal','Gratuita','Monteagudo','Zona Central, municipio de Monteagudo',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','sistemas-informaticos','gastronomia']],
            ['instituto-tecnologico-camargo','Instituto Tecnológico Superior Camargo','ITSC','Instituto técnico/tecnológico','Fiscal','Gratuita','Camargo','Zona Central, municipio de Camargo',null,['ingenieria-agropecuaria','industria-de-alimentos','turismo','sistemas-informaticos']],
            ['instituto-tecnologico-zudanez','Instituto Tecnológico Superior Zudáñez','ITSZ','Instituto técnico/tecnológico','Fiscal','Gratuita','Zudáñez','Zona Central, municipio de Zudáñez',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos']],
            ['instituto-tecnologico-tarabuco','Instituto Tecnológico Superior Tarabuco','ITST','Instituto técnico/tecnológico','Fiscal','Gratuita','Tarabuco','Zona Central, municipio de Tarabuco',null,['ingenieria-agropecuaria','industria-textil-y-confeccion','turismo']],
            ['instituto-tecnologico-padilla','Instituto Tecnológico Superior Padilla','ITSP','Instituto técnico/tecnológico','Fiscal','Gratuita','Padilla','Zona Central, municipio de Padilla',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','sistemas-informaticos']],
        ];
        foreach($rows as $row)$this->save($department->id,$row);
    }

    private function save(int $departmentId,array $row):void
    {
        [$slug,$name,$acronym,$type,$ownership,$payment,$city,$address,$website,$slugs]=$row;$phone=$row[10]??null;
        $institution=Institution::updateOrCreate(['slug'=>$slug],['department_id'=>$departmentId,'name'=>$name,'acronym'=>$acronym,'institution_type'=>$type,'ownership'=>$ownership,'payment_type'=>$payment,'description'=>($type==='Universidad'?'Universidad':'Institución de educación superior técnica')." con sede en {$city} y oferta académica formal.",'cost_notes'=>$payment==='Gratuita'?'Confirmar matrícula, materiales y valores administrativos.':'Consultar aranceles con la institución.','schedule_notes'=>'Consultar horarios según carrera y gestión.','city'=>$city,'address'=>$address,'phone'=>$phone,'website'=>$website,'source_url'=>$website?:self::GUIDE,'is_verified'=>true,'verified_at'=>now(),'is_active'=>true]);
        foreach(Career::whereIn('slug',$slugs)->get() as $career)$institution->careers()->syncWithoutDetaching([$career->id=>['degree_level'=>$type==='Universidad'?'Licenciatura':'Técnico Superior','modality'=>'Presencial','schedule'=>'Consultar con la institución','duration_text'=>$career->duration_text?:($type==='Universidad'?'Consultar plan de estudios':'3 años'),'labor_demand'=>'Variado','labor_demand_notes'=>null,'is_active'=>true]]);
    }
}
