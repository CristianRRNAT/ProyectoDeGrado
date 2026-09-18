<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class SantaCruzInstitutionsSeeder extends Seeder
{
    private const GUIDE = 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf';

    public function run(): void
    {
        $department = Department::where('slug', 'santa-cruz')->firstOrFail();
        $universities = [
            ['universidad-autonoma-gabriel-rene-moreno','Universidad Autónoma Gabriel René Moreno','UAGRM','Pública','Gratuita','Santa Cruz de la Sierra','Campus Universitario, avenida Busch, entre 2.º y 3.er anillo','https://www.uagrm.edu.bo/',['medicina','enfermeria','bioquimica','ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-informatica','ingenieria-agronomica','medicina-veterinaria-y-zootecnia','arquitectura','derecho','psicologia','comunicacion-social','economia','administracion-de-empresas','contaduria-publica','ingenieria-comercial']],
            ['universidad-privada-santa-cruz-de-la-sierra','Universidad Privada de Santa Cruz de la Sierra','UPSA','Privada','De pago','Santa Cruz de la Sierra','Av. Paraguá y 4.º anillo','https://www.upsa.edu.bo/',['arquitectura','diseno-grafico','ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-electronica','administracion-de-empresas','economia','ingenieria-comercial','ingenieria-financiera','derecho','comunicacion-social']],
            ['universidad-tecnologica-privada-santa-cruz','Universidad Tecnológica Privada de Santa Cruz','UTEPSA','Privada','De pago','Santa Cruz de la Sierra','3.er anillo interno N.º 715, entre av. Busch y av. San Martín','https://www.utepsa.edu/',['ingenieria-de-sistemas','ingenieria-industrial','ingenieria-electronica','ingenieria-comercial','administracion-de-empresas','contaduria-publica','derecho','comunicacion-social','psicologia']],
            ['universidad-privada-domingo-savio-santa-cruz','Universidad Privada Domingo Savio - Santa Cruz','UPDS','Privada','De pago','Santa Cruz de la Sierra','Av. Beni y 3.er anillo externo','https://www.upds.edu.bo/',['ingenieria-de-sistemas','ingenieria-industrial','ingenieria-civil','arquitectura','administracion-de-empresas','contaduria-publica','ingenieria-comercial','derecho','psicologia','comunicacion-social']],
            ['universidad-privada-franz-tamayo-santa-cruz','Universidad Privada Franz Tamayo - Santa Cruz','UNIFRANZ','Privada','De pago','Santa Cruz de la Sierra','Av. Busch esquina 2.º anillo N.º 1113','https://unifranz.edu.bo/sedes/santa-cruz/',['medicina','odontologia','enfermeria','bioquimica','ingenieria-de-sistemas','arquitectura','derecho','psicologia','administracion-de-empresas','ingenieria-comercial','diseno-grafico']],
            ['universidad-de-aquino-bolivia-santa-cruz','Universidad de Aquino Bolivia - Santa Cruz','UDABOL','Privada','De pago','Santa Cruz de la Sierra','3.er anillo interno y radial 23','https://www.udabol.edu.bo/',['medicina','odontologia','enfermeria','bioquimica','fisioterapia-y-kinesiologia','ingenieria-de-sistemas','ingenieria-comercial','derecho','psicologia']],
            ['universidad-cristiana-de-bolivia','Universidad Cristiana de Bolivia','UCEBOL','Privada','De pago','Santa Cruz de la Sierra','Av. Cristo Redentor, entre 6.º y 7.º anillo','https://www.ucebol.edu.bo/',['medicina','odontologia','bioquimica','enfermeria','medicina-veterinaria-y-zootecnia','ingenieria-de-sistemas','administracion-de-empresas','derecho']],
            ['universidad-nacional-ecologica','Universidad Nacional Ecológica','UNE','Privada','De pago','Santa Cruz de la Sierra','Av. Mutualista, entre 4.º y 5.º anillo','https://www.universidadecologica.edu.bo/',['ingenieria-ambiental','ingenieria-agronomica','medicina-veterinaria-y-zootecnia','bioquimica','enfermeria','administracion-de-empresas','derecho']],
            ['universidad-evangelica-boliviana','Universidad Evangélica Boliviana','UEB','Privada','De pago','Santa Cruz de la Sierra','Av. Cristo Redentor km 6,5','https://www.ueb.edu.bo/',['medicina','enfermeria','nutricion-y-dietetica','psicologia','comunicacion-social','ingenieria-de-sistemas','administracion-de-empresas']],
            ['universidad-catolica-boliviana-santa-cruz','Universidad Católica Boliviana San Pablo - Santa Cruz','UCB','Privada','De pago','Santa Cruz de la Sierra','Km 9 carretera al Norte','https://scz.ucb.edu.bo/',['ingenieria-industrial','ingenieria-de-sistemas','ingenieria-ambiental','arquitectura','administracion-de-empresas','derecho','psicologia','comunicacion-social','ingenieria-comercial']],
        ];
        foreach ($universities as $row) $this->save($department->id, $row, 'Universidad');

        $institutes = [
            ['instituto-tecnologico-popular-igualitario-andres-ibanez','Instituto Tecnológico Popular Igualitario Andrés Ibáñez','ITPIAI','Fiscal','Gratuita','Santa Cruz de la Sierra','Av. Rosales, barrio Suárez Pompeya, Plan 3000',null,['ingenieria-agropecuaria','electronica','gastronomia','comunicacion-social','informatica-industrial','sistemas-informaticos','industria-de-alimentos','industria-textil-y-confeccion']],
            ['instituto-tecnologico-fabril-santa-cruz','Instituto Tecnológico Fabril de Santa Cruz','ITFSC','Fiscal','Gratuita','Santa Cruz de la Sierra','Parque Industrial Latinoamericano, zona este',null,['mecanica-industrial','electricidad-industrial','electronica','industria-textil-y-confeccion','industria-de-alimentos']],
            ['instituto-tecnologico-santa-cruz','Instituto Tecnológico Santa Cruz','ITSC','Fiscal','Gratuita','Santa Cruz de la Sierra','Barrio 24 de Septiembre, radial 26, a 300 metros del 4.º anillo',null,['mecanica-automotriz','mecanica-industrial','electricidad-industrial','electronica','sistemas-informaticos']],
            ['instituto-tecnologico-agustin-chi-raye','Instituto Tecnológico Agustín Chi Raye','ITACH','Fiscal','Gratuita','Santa Cruz de la Sierra','Municipio de Santa Cruz de la Sierra',null,['ingenieria-agropecuaria']],
            ['instituto-tecnologico-infocal-santa-cruz','Instituto Tecnológico INFOCAL Santa Cruz','INFOCAL','Privada','De pago','Santa Cruz de la Sierra','Av. Banzer km 8,5','https://infocal.com.bo/',['mecanica-automotriz','mecanica-industrial','electricidad-industrial','electronica','gastronomia','sistemas-informaticos','enfermeria']],
            ['instituto-tecnologico-latinoamericano-tel','Instituto Tecnológico Latinoamericano TEL','TEL','Privada','De pago','Santa Cruz de la Sierra','Av. Irala N.º 585','https://www.tel.edu.bo/',['enfermeria','fisioterapia-y-kinesiologia','laboratorio-clinico','nutricion-y-dietetica','sistemas-informaticos']],
            ['instituto-tecnico-prosal','Instituto Técnico de Programas de Salud PROSAL','PROSAL','Privada','De pago','Santa Cruz de la Sierra','Av. Cañoto, zona Central',null,['enfermeria','fisioterapia-y-kinesiologia','laboratorio-clinico','nutricion-y-dietetica']],
            ['instituto-tecnologico-superior-miraflores','Instituto Tecnológico Superior Miraflores','ITSM','Fiscal','Gratuita','Santa Cruz de la Sierra','Barrio Miraflores, zona norte',null,['sistemas-informaticos','contaduria-general','secretariado-ejecutivo','gastronomia']],
            ['instituto-tecnologico-san-ignacio-de-velasco','Instituto Tecnológico San Ignacio de Velasco','ITIV','Fiscal','Gratuita','San Ignacio de Velasco','Zona Pueblo Nuevo, San Ignacio de Velasco',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos','turismo','sistemas-informaticos']],
            ['instituto-tecnologico-agropecuario-portachuelo','Instituto Tecnológico Agropecuario Portachuelo','ITAP','Fiscal','Gratuita','Portachuelo','Carretera Portachuelo a Buena Vista',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','industria-de-alimentos']],
            ['instituto-tecnologico-superior-guarayos','Instituto Tecnológico Superior Guarayos','ITSG','Fiscal','Gratuita','Ascensión de Guarayos','Zona Central, Ascensión de Guarayos',null,['ingenieria-agropecuaria','veterinaria-y-zootecnia','sistemas-informaticos','turismo']],
            ['instituto-tecnologico-montereño','Instituto Tecnológico Montereño','ITM','Fiscal','Gratuita','Montero','Barrio La Floresta, Montero',null,['mecanica-automotriz','electricidad-industrial','sistemas-informaticos','contaduria-general','gastronomia']],
            ['escuela-superior-bellas-artes-raul-g-ovtero-reiche','Escuela Superior de Bellas Artes Raúl G. Otero Reiche','ESBA','Fiscal','Gratuita','Santa Cruz de la Sierra','Calle Sucre, zona Central',null,['artes-plasticas-y-visuales']],
            ['instituto-formacion-artistica-bellas-artes-san-ignacio','Instituto de Formación Artística Bellas Artes San Ignacio','IFA','Fiscal','Gratuita','San Ignacio de Velasco','Zona Central, San Ignacio de Velasco',null,['musica','artes-plasticas-y-visuales']],
        ];
        foreach ($institutes as $row) $this->save($department->id, $row, 'Instituto técnico/tecnológico');
    }

    private function save(int $departmentId, array $row, string $type): void
    {
        [$slug,$name,$acronym,$ownership,$payment,$city,$address,$website,$careerSlugs]=$row;
        $institution=Institution::updateOrCreate(['slug'=>$slug],['department_id'=>$departmentId,'name'=>$name,'acronym'=>$acronym,'institution_type'=>$type,'ownership'=>$ownership,'payment_type'=>$payment,'description'=>($type==='Universidad'?'Universidad':'Institución de formación técnica superior')." con sede en {$city} y oferta académica registrada.",'cost_notes'=>$payment==='Gratuita'?'Confirmar valores administrativos y materiales.':'Consultar aranceles directamente con la institución.','schedule_notes'=>'Los horarios varían según carrera y gestión.','city'=>$city,'address'=>$address,'website'=>$website,'source_url'=>$website ?: self::GUIDE,'is_verified'=>true,'verified_at'=>now(),'is_active'=>true]);
        foreach(Career::whereIn('slug',$careerSlugs)->get() as $career) $institution->careers()->syncWithoutDetaching([$career->id=>['degree_level'=>$type==='Universidad'?'Licenciatura':'Técnico Superior','modality'=>'Presencial','schedule'=>'Consultar con la institución','duration_text'=>$career->duration_text ?: ($type==='Universidad'?'Consultar plan de estudios':'3 años'),'labor_demand'=>'Variado','labor_demand_notes'=>null,'is_active'=>true]]);
    }
}
