<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\AcademicArea;
use App\Models\Department;
use App\Models\Institution;
use App\Models\InstitutionUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CochabambaInstitutionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('institution_career')->update(['labor_demand' => 'Variado', 'labor_demand_notes' => null]);
        $department = Department::where('slug', 'cochabamba')->firstOrFail();
        $this->ensureCareer('danza', 'Danza', 'Formación artística en expresión corporal, técnica, interpretación y creación escénica.');
        $this->ensureCareer('formacion-deportiva-en-futbol', 'Formación deportiva en fútbol', 'Proceso formativo para desarrollar fundamentos técnicos, tácticos, físicos y valores deportivos mediante el fútbol.');
        $this->ensureCareer('modelaje-profesional', 'Modelaje profesional', 'Formación especializada en pasarela, expresión corporal, imagen, fotografía y proyección personal.');
        $umss = $this->institution($department->id, 'universidad-mayor-de-san-simon', [
            'name' => 'Universidad Mayor de San Simón', 'acronym' => 'UMSS', 'institution_type' => 'Universidad', 'ownership' => 'Pública', 'payment_type' => 'Gratuita',
            'description' => 'Universidad pública de Cochabamba organizada en facultades y unidades académicas, con oferta de grado, técnico universitario y formación desconcentrada.',
            'cost_notes' => 'La matrícula, valores universitarios y otros gastos deben confirmarse en la convocatoria vigente.', 'schedule_notes' => 'Los horarios varían según facultad, carrera, semestre y grupo.',
            'city' => 'Cochabamba', 'address' => 'Av. Oquendo y calle Jordán, campus central', 'phone' => '4251515', 'email' => 'informaciones@umss.edu.bo',
            'website' => 'https://www.umss.edu.bo/', 'source_url' => 'https://disu.umss.edu.bo/carreras_umss/',
        ]);
        $units = ['Facultad de Arquitectura y Ciencias del Hábitat','Facultad de Ciencias Agrícolas, Pecuarias y Forestales','Facultad de Ciencias Económicas','Facultad de Ciencias Farmacéuticas y Bioquímicas','Facultad de Ciencias Jurídicas y Políticas','Facultad de Ciencias Sociales','Facultad de Ciencias y Tecnología','Facultad de Ciencias Veterinarias','Facultad de Desarrollo Rural y Territorial','Facultad de Enfermería','Facultad de Humanidades y Ciencias de la Educación','Facultad de Medicina','Facultad de Odontología','Facultad Politécnica del Valle Alto'];
        foreach ($units as $i => $name) $this->unit($umss, $name, 'Facultad', $i + 1);
        $this->attach($umss, 'Facultad de Ciencias y Tecnología', ['ingenieria-de-alimentos','ingenieria-civil','ingenieria-mecanica','ingenieria-electromecanica','ingenieria-industrial','ingenieria-de-sistemas','ingenieria-quimica','ingenieria-electrica','ingenieria-informatica','ingenieria-petroquimica','ingenieria-electronica','ingenieria-matematica','biologia','fisica','matematicas','quimica','gastronomia']);
        $this->attach($umss, 'Facultad de Arquitectura y Ciencias del Hábitat', ['arquitectura','turismo','diseno-de-interiores','diseno-grafico','construccion-civil']);
        $this->attach($umss, 'Facultad de Ciencias Agrícolas, Pecuarias y Forestales', ['ingenieria-agronomica','ingenieria-agroindustrial','ingenieria-forestal']);
        $this->attach($umss, 'Facultad de Ciencias Económicas', ['economia','administracion-de-empresas','contaduria-publica']);
        $this->attach($umss, 'Facultad de Ciencias Farmacéuticas y Bioquímicas', ['bioquimica','quimica-farmaceutica']);
        $this->attach($umss, 'Facultad de Ciencias Jurídicas y Políticas', ['derecho','ciencia-politica-y-gestion-publica']);
        $this->attach($umss, 'Facultad de Ciencias Sociales', ['sociologia','antropologia-y-arqueologia']);
        $this->attach($umss, 'Facultad de Ciencias Veterinarias', ['medicina-veterinaria-y-zootecnia']);
        $this->attach($umss, 'Facultad de Desarrollo Rural y Territorial', ['administracion-rural','agroecologia']);
        $this->attach($umss, 'Facultad de Enfermería', ['enfermeria']);
        $this->attach($umss, 'Facultad de Humanidades y Ciencias de la Educación', ['psicologia','ciencias-de-la-educacion','comunicacion-social','linguistica-e-idiomas','trabajo-social','actividad-fisica-y-del-deporte','musica','educacion-parvularia']);
        $this->attach($umss, 'Facultad de Medicina', ['medicina','fisioterapia-y-kinesiologia','nutricion-y-dietetica']);
        $this->attach($umss, 'Facultad de Odontología', ['odontologia']);
        $this->attach($umss, 'Facultad Politécnica del Valle Alto', ['mecanica-automotriz','electricidad-industrial','industria-de-alimentos']);

        $ucb = $this->institution($department->id, 'universidad-catolica-boliviana-san-pablo-cochabamba', [
            'name' => 'Universidad Católica Boliviana San Pablo - Sede Cochabamba', 'acronym' => 'UCB', 'institution_type' => 'Universidad', 'ownership' => 'Privada', 'payment_type' => 'De pago',
            'description' => 'Sede Cochabamba con programas en salud, ingeniería, ciencias sociales, humanidades, administración y economía.',
            'cost_notes' => 'Los aranceles dependen de la carrera y periodo académico; deben consultarse con Admisiones.', 'schedule_notes' => 'Los horarios dependen de la carrera, semestre y campus.',
            'city' => 'Cochabamba', 'address' => 'Calle M. Márquez esquina Parque Jorge Trigo Andia, Campus Tupuraya', 'phone' => '4293100', 'email' => 'infoucatolica.cba@ucb.edu.bo',
            'website' => 'https://cba.ucb.edu.bo/', 'source_url' => 'https://cba.ucb.edu.bo/oferta-pregrado-ucb-cochabamba/',
        ]);
        $groups = [
            'Ciencias de la Salud' => ['medicina','enfermeria','odontologia','fisioterapia-y-kinesiologia'],
            'Ingeniería y Ciencias Exactas' => ['arquitectura','ingenieria-ambiental','ingenieria-civil','ingenieria-industrial','ingenieria-quimica','ingenieria-mecatronica','ingenieria-de-sistemas'],
            'Ciencias Sociales y Humanas' => ['antropologia','comunicacion-social','derecho','psicologia'],
            'Administración y Economía' => ['administracion-de-empresas','contaduria-publica','ingenieria-comercial','ingenieria-financiera'],
            'Facultad de Teología San Pablo' => ['teologia'],
        ];
        foreach ($groups as $name => $slugs) { $this->unit($ucb, $name, 'Área académica', array_search($name, array_keys($groups)) + 1); $this->attach($ucb, $name, $slugs); }

        $this->university($department->id, 'universidad-central-cochabamba', 'Universidad Central - Sede Cochabamba', 'UNICEN', 'Calle Santiváñez y Junín N.º 240', 'https://unicen.edu.bo/', [
            'Área empresarial y jurídica' => ['administracion-de-empresas','administracion-de-hoteleria-y-turismo','contaduria-publica','derecho','ingenieria-comercial','ingenieria-financiera'],
            'Ciencias de la Salud' => ['fisioterapia-y-kinesiologia'], 'Innovación y tecnología' => ['ingenieria-de-software'],
        ]);
        $this->university($department->id, 'universidad-privada-abierta-latinoamericana-cochabamba', 'Universidad Privada Abierta Latinoamericana - Cochabamba', 'UPAL', 'Calle Túpac Amaru N.º 1816 esquina Paso del Inca', 'https://www.upal.edu.bo/', [
            'Ciencias de la Salud' => ['medicina','bioquimica','odontologia'], 'Ciencias sociales y empresariales' => ['administracion-de-empresas','comunicacion-social','derecho','ingenieria-comercial','ingenieria-financiera','psicologia'],
        ]);
        $this->university($department->id, 'universidad-privada-boliviana-campus-cochabamba', 'Universidad Privada Boliviana - Campus Cochabamba', 'UPB', 'Av. Capitán Víctor Ustáriz km 6,5', 'https://www.upb.edu/campus/cochabamba', [
            'Ingeniería y Arquitectura' => ['ingenieria-electromecanica','ingenieria-industrial','ingenieria-de-petroleo-y-gas-natural','ingenieria-civil','ingenieria-ambiental','ingenieria-de-sistemas','ingenieria-electronica','arquitectura'],
            'Ciencias Empresariales y Derecho' => ['administracion-de-empresas','economia','ingenieria-comercial','ingenieria-financiera','derecho','comunicacion-social','psicologia','diseno-grafico'],
        ]);
        $unitepc = $this->university($department->id, 'universidad-tecnica-privada-cosmos-cochabamba', 'Universidad Técnica Privada Cosmos - Sede Cochabamba', 'UNITEPC', 'Av. Heroínas, edificio Colonial', 'https://unitepc.edu.bo/', [
            'Ciencias de la Salud' => ['medicina','odontologia','enfermeria','bioquimica','fonoaudiologia','nutricion-y-dietetica'],
            'Ingeniería' => ['ingenieria-de-sonido','ingenieria-de-sistemas','ingenieria-electronica'],
            'Ciencias económicas y jurídicas' => ['contaduria-publica','economia','administracion-de-empresas','ingenieria-comercial','comunicacion-social','derecho'],
        ]);
        foreach (['medicina'=>'6 años','odontologia'=>'5 años','enfermeria'=>'4 años','bioquimica'=>'5 años','fonoaudiologia'=>'4 años y medio','nutricion-y-dietetica'=>'4 años y medio','ingenieria-de-sonido'=>'4 años y medio','ingenieria-de-sistemas'=>'4 años','ingenieria-electronica'=>'4 años','contaduria-publica'=>'4 años','economia'=>'4 años','administracion-de-empresas'=>'4 años y medio','ingenieria-comercial'=>'4 años','comunicacion-social'=>'4 años','derecho'=>'4 años y medio'] as $slug => $duration) {
            $careerId = Career::where('slug', $slug)->value('id'); if ($careerId) DB::table('institution_career')->where('institution_id', $unitepc->id)->where('career_id', $careerId)->update(['duration_text' => $duration]);
        }
        $this->university($department->id, 'universidad-de-aquino-bolivia-cochabamba', 'Universidad de Aquino Bolivia - Subsede Cochabamba', 'UDABOL', 'Km 8,5 carretera a Sacaba', 'https://www.udabol.edu.bo/', [
            'Oferta académica' => ['medicina','odontologia','bioquimica','enfermeria','derecho','administracion-de-empresas','ingenieria-comercial','ingenieria-de-sistemas'],
        ]);
        $this->university($department->id, 'universidad-privada-del-valle-cochabamba', 'Universidad Privada del Valle - Cochabamba', 'UNIVALLE', 'Campus Tiquipaya, Cochabamba', 'https://www.univalle.edu/', [
            'Ciencias de la Salud' => ['medicina','odontologia','bioquimica','fisioterapia-y-kinesiologia','enfermeria','nutricion-y-dietetica'],
            'Ingeniería y otras áreas' => ['ingenieria-civil','ingenieria-industrial','ingenieria-de-sistemas','arquitectura','derecho','administracion-de-empresas'],
        ]);

        $usip = $this->university($department->id, 'universidad-simon-i-patino', 'Universidad Simón I. Patiño', 'USIP', 'Av. Villazón N.º 22, km 1 carretera a Sacaba', 'https://usip.edu.bo/', [
            'Ingeniería y arquitectura' => ['arquitectura','ingenieria-electromecanica','ingenieria-de-sistemas'],
            'Ciencias sociales y empresariales' => ['derecho','ingenieria-comercial'],
            'Carreras técnicas' => ['ingenieria-de-software','administracion-de-empresas'],
        ]);
        $usip->update(['phone' => '69425203 / 69425211', 'email' => 'info@usip.edu.bo', 'description' => 'Universidad privada cochabambina con programas de licenciatura, ingeniería y formación técnica en software y administración de negocios.']);
        $technicalUnit = InstitutionUnit::where('institution_id', $usip->id)->where('slug', Str::slug('Carreras técnicas'))->first();
        if ($technicalUnit) DB::table('institution_career')->where('institution_id', $usip->id)->where('institution_unit_id', $technicalUnit->id)->update(['degree_level' => 'Técnico Superior', 'duration_text' => '3 años']);

        $cepro = $this->privateTechnical($department->id, 'instituto-tecnologico-cepro', 'Instituto Tecnológico CEPRO', 'Cochabamba', 'Av. San Martín N.º 474, edificio Shopping Center, piso 2', '4457745 / 76438829', ['sistemas-informaticos','secretariado-ejecutivo','contaduria-general','electronica']);
        $cepro->update([
            'website' => 'https://www.institutocepro.edu.bo/', 'source_url' => 'https://www.institutocepro.edu.bo/careers',
            'email' => 'info@institutocepro.edu.bo',
            'description' => 'Instituto tecnológico privado con carreras de Técnico Superior en Sistemas Informáticos, Secretariado Ejecutivo, Contaduría General y Electrónica.',
            'campuses' => [
                ['name' => 'Sede Cochabamba', 'address' => 'Av. San Martín N.º 474, edificio Shopping Center, piso 2', 'city' => 'Cochabamba'],
                ['name' => 'Subsede Quillacollo', 'address' => 'Calle General Pando entre Ballivián, Shopping Guadalupe, piso 2', 'city' => 'Quillacollo'],
            ],
        ]);

        $sur = $this->privateTechnical($department->id, 'instituto-tecnologico-del-sur-cochabamba', 'Instituto Tecnológico del Sur', 'Cochabamba', 'Av. San Martín N.º 930, edificio Darius, piso 4, entre Brasil y Montes', '4227019', ['contaduria-general','parvularia','sistemas-informaticos','fisioterapia-y-kinesiologia','electronica','industria-de-alimentos','comercio-internacional','optometria','laboratorio-clinico','laboratorio-dental']);
        $sur->update(['source_url' => 'https://www.minedu.gob.bo/files/documentos-normativos/VESFP/2024/reglamentos/GUIA-INSTITUTOS-2024-OCTUBRE.pdf', 'description' => 'Instituto privado autorizado con formación técnica en administración, tecnología, industria y salud. Su oferta no incluye Enfermería; en el área sanitaria registra Fisioterapia, Optometría, Laboratorio Clínico y Laboratorio Dental.']);
        foreach (['laboratorio-clinico','laboratorio-dental'] as $slug) {
            $careerId = Career::where('slug', $slug)->value('id');
            if ($careerId) DB::table('institution_career')->where('institution_id', $sur->id)->where('career_id', $careerId)->update(['degree_level' => 'Técnico Medio']);
        }

        $federico = $this->institution($department->id, 'instituto-tecnico-nacional-de-comercio-federico-alvarez-plata', [
            'name' => 'Instituto Técnico Nacional de Comercio Federico Álvarez Plata', 'acronym' => 'FAP',
            'institution_type' => 'Instituto técnico', 'ownership' => 'Fiscal', 'payment_type' => 'Gratuita',
            'description' => 'Instituto fiscal de formación técnica superior con oferta académica diurna y nocturna.',
            'cost_notes' => 'Confirmar valores administrativos y materiales directamente con el instituto.',
            'schedule_notes' => 'Diurno y nocturno', 'city' => 'Cochabamba', 'address' => 'Av. Ayacucho esquina calle Jordán N.º 415',
            'phone' => '4258041 / 4257971', 'source_url' => null,
        ]);
        $this->attachDirect($federico, ['contaduria-general','secretariado-ejecutivo'], 'Diurno y nocturno');
        $this->attachDirect($federico, ['turismo','gastronomia'], 'Diurno');
        $this->attachDirect($federico, ['marketing-y-publicidad','sistemas-informaticos'], 'Nocturno');
        Institution::whereIn('slug', ['instituto-tecnico-nacional-de-comercio-federico-alvarez-plata-diurno','instituto-tecnico-nacional-de-comercio-federico-alvarez-plata-nocturno'])->delete();
        $this->technical($department->id, 'instituto-tecnico-superior-de-comercio-y-administracion-esae', 'Instituto Técnico Superior de Comercio y Administración ESAE', 'Cochabamba', 'Av. Heroínas esquina Belzu N.º 1641, zona San Pedro', '4569265', ['administracion-de-empresas','marketing-y-publicidad'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnico-nacional-de-comercio-incos-3', 'Instituto Técnico Nacional de Comercio INCOS N.º 3', 'Quillacollo', 'Calle Cincinato Prada s/n', '4390361', ['contaduria-general','secretariado-ejecutivo','gastronomia','administracion-de-empresas','sistemas-informaticos','turismo'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-alvaro-garcia-linera', 'Instituto Tecnológico Álvaro García Linera', 'Shinahota', 'Barrio Barrientos, zona La Chancadora', null, ['administracion-de-empresas','electricidad-industrial','gastronomia','mecanica-industrial','mecanica-automotriz','construccion-civil'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-ivan-j-canelas-a', 'Instituto Tecnológico Iván J. Canelas A.', 'Vinto', 'Anocaraire, cuarta sección de Vinto', null, ['mecanica-automotriz','informatica-industrial','industria-de-alimentos','construccion-civil','ingenieria-agropecuaria','gastronomia'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-agropecuario-industrial-tarata', 'Instituto Tecnológico Agropecuario Industrial Tarata', 'Tarata', 'Av. Igualdad s/n, zona sudoeste', '4578117', ['ingenieria-agropecuaria','industria-de-alimentos','veterinaria-y-zootecnia'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-superior-agroindustrial-aiquile', 'Instituto Tecnológico Superior Agroindustrial Aiquile', 'Aiquile', 'Villa Guadalupe, zona Pista', null, ['sistemas-informaticos','ingenieria-agropecuaria','industria-de-alimentos','veterinaria-y-zootecnia','contaduria-general','turismo'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-agropecuario-canada', 'Instituto Tecnológico Agropecuario Canadá', 'Chimoré', 'Av. Abecedario s/n', '50202063', ['turismo','ingenieria-agropecuaria','veterinaria-y-zootecnia','mecanica-automotriz','administracion-de-empresas'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-industrial-comercial-puerto-mejillones', 'Instituto Tecnológico Industrial Comercial Puerto Mejillones', 'Cochabamba', 'Calle Zenobio Gallardo N.º 3454', '4490621', ['secretariado-ejecutivo','electricidad-industrial','electronica','construccion-civil','topografia-y-geodesia'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-presidente-evo-morales-ayma', 'Instituto Tecnológico Presidente Evo Morales Ayma', 'Villa Tunari', 'Localidad San Francisco', null, ['gastronomia','mecanica-industrial','mecanica-automotriz','administracion-de-empresas'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-boliviano-canadiense-el-paso', 'Instituto Tecnológico Boliviano Canadiense El Paso', 'Quillacollo', 'Av. Elías Meneses s/n, zona El Paso', '4319934', ['mecanica-industrial','quimica-industrial','mecanica-automotriz','electricidad-industrial','industria-de-alimentos'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-avelino-sinani-de-mizque', 'Instituto Tecnológico Avelino Siñani de Mizque', 'Mizque', 'Calle Litoral esquina Guillermo Vizcarra, comunidad Mollo', null, ['veterinaria-y-zootecnia','ingenieria-agropecuaria','turismo','acuicultura'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-avelino-sinani-de-mizque-subsede-mina-asientos', 'Instituto Tecnológico Avelino Siñani de Mizque - Subsede Mina Asientos', 'Mina Asientos', 'Zona El Calvario', null, ['contaduria-general','mecanica-industrial'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-berto-nicoli', 'Instituto Tecnológico Berto Nicoli', 'Sacaba', 'Calle San Rafael s/n y final Ismael Céspedes, zona Chimboco', null, ['veterinaria-y-zootecnia','industria-de-alimentos','construccion-civil','ingenieria-agropecuaria'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-comandante-hugo-chavez-frias', 'Instituto Tecnológico Comandante Hugo Chávez Frías', 'Villa Tunari', 'Av. Tajibos, localidad Isinuta', null, ['construccion-civil','contaduria-general','mecanica-automotriz','gastronomia'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-guerrilleros-de-independencia', 'Instituto Tecnológico Guerrilleros de Independencia', 'Independencia', 'Camino vecinal a La Vega s/n', null, ['mecanica-automotriz','electronica','industria-de-alimentos','administracion-de-empresas'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-entre-rios', 'Instituto Tecnológico Entre Ríos', 'Entre Ríos', 'Av. Camino a Bajo El Palmar', '77939048', ['ingenieria-agropecuaria','gastronomia','administracion-de-empresas','mecanica-automotriz'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-maria-cristina', 'Instituto Tecnológico María Cristina', 'Colcapirhua', 'Av. Capitán Víctor Ustáriz km 6½, zona Santa Rosa', '4376870', ['industria-textil-y-confeccion','gastronomia','belleza-integral','informatica-industrial'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-superior-ivirgarzama', 'Instituto Tecnológico Superior Ivirgarzama', 'Ivirgarzama', 'Carretera Cochabamba-Santa Cruz', null, ['secretariado-ejecutivo','gastronomia','turismo','construccion-civil'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-mineros-san-juan', 'Instituto Tecnológico Mineros San Juan', 'Cochabamba', 'Calle Planeta Venus entre Annie Jump, Planeta Plutón y Aristóteles', null, ['gastronomia','contaduria-general','mecanica-automotriz','secretariado-ejecutivo','electronica'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-industrial-puerto-de-mejillones-colomi', 'Instituto Tecnológico Industrial Puerto de Mejillones Colomi', 'Colomi', 'Calle Man Césped y Antofagasta', null, ['industria-de-alimentos','gastronomia','electricidad-industrial','topografia-y-geodesia','ingenieria-agropecuaria','mecanica-automotriz'], 'Consultar');
        $this->technical($department->id, 'instituto-tecnologico-superior-esperanza', 'Instituto Tecnológico Superior Esperanza', 'Sacabamba', 'Calle innominada', null, ['industria-de-alimentos','ingenieria-agropecuaria'], 'Consultar');
        $this->convenio($department->id, 'instituto-tecnologico-amor-misericordioso', 'Instituto Tecnológico Amor Misericordioso', 'Quillacollo', 'Localidad Marquina, camino del Tupuyán s/n', '4366451', ['mecanica-industrial','electricidad-industrial','industria-textil-y-confeccion','industria-de-la-madera']);
        $maria = $this->convenio($department->id, 'instituto-tecnico-maria-inmaculada', 'Instituto Técnico María Inmaculada', 'Quillacollo', 'Av. Cochabamba km 10½, camino antiguo a Quillacollo', '44260084', ['enfermeria']);
        DB::table('institution_career')->where('institution_id', $maria->id)->update(['degree_level' => 'Técnico Medio', 'duration_text' => '2 años']);
        $this->convenio($department->id, 'instituto-tecnologico-eterazama', 'Instituto Tecnológico Eterazama', 'Villa Tunari', 'Zona Las Palmas', null, ['enfermeria','sistemas-informaticos','agroindustria','agroecologia']);
        $this->convenio($department->id, 'instituto-tecnologico-nuestra-senora-del-pilar', 'Instituto Tecnológico Nuestra Señora del Pilar', 'Cochabamba', 'Calle Tarwi y torrentera La Pajcha, Ticti Norte', '4476396', ['administracion-de-empresas','electricidad-industrial','mecanica-industrial']);
        $padreBerta = $this->convenio($department->id, 'instituto-tecnologico-padre-antonio-berta', 'Instituto Tecnológico Padre Antonio Berta', 'Tiquipaya', 'Av. O’Connor entre Tomás Frías, Sumumpaya Norte', '4223421', ['mecanica-industrial','electricidad-industrial','electronica','mecanica-automotriz']);
        $padreBerta->update(['website' => 'https://www.tecnologicopadreantonioberta.edu.bo/', 'source_url' => 'https://www.tecnologicopadreantonioberta.edu.bo/', 'description' => 'Instituto de convenio orientado a la formación técnica práctica, el emprendimiento y la inserción laboral en áreas industriales, eléctricas, electrónicas y automotrices.']);
        $this->convenio($department->id, 'instituto-tecnologico-sayarinapaj', 'Instituto Tecnológico Sayarinapaj', 'Quillacollo', 'Km 8 carretera a Liriuni, zona Bella Vista', '4368370 / 4567259', ['ingenieria-agropecuaria','electricidad-industrial','trabajo-social','mecanica-industrial','parvularia','gastronomia']);
        $infocalTupuraya = $this->privateTechnical($department->id, 'instituto-tecnologico-infocal-tupuraya-cochabamba', 'Instituto Tecnológico INFOCAL - Subsede Tupuraya', 'Cochabamba', 'Av. General Galindo N.º 1406, zona Tupuraya', '4242660', ['parvularia','sistemas-informaticos','gastronomia','mecanica-automotriz','turismo','construccion-civil','contaduria-general','informatica-industrial','marketing-y-publicidad']);
        $infocalTupuraya->update(['website' => 'https://www.infocalcbba.edu.bo/', 'source_url' => 'https://www.infocalcbba.edu.bo/', 'description' => 'Subsede privada de INFOCAL Cochabamba enfocada en formación práctica para servicios, tecnología, construcción, administración y mecánica, con talleres y recursos aplicados a cada especialidad.']);
        $infocalArocagua = $this->privateTechnical($department->id, 'instituto-tecnologico-infocal-arocagua-cochabamba', 'Instituto Tecnológico INFOCAL - Subsede Arocagua', 'Cochabamba', 'Av. Villazón km 3, carretera a Sacaba', '4292777', ['electromecanica-industrial','electrotecnia-industrial','mecanica-industrial']);
        $infocalArocagua->update(['website' => 'https://www.infocalcbba.edu.bo/', 'source_url' => 'https://www.infocalcbba.edu.bo/', 'description' => 'Subsede industrial de INFOCAL Cochabamba especializada en electromecánica, electrotecnia y mecánica industrial mediante formación técnica práctica.']);
        Institution::whereIn('slug', [
            'centro-capacitacion-tecnica-moderna-dallas',
            'instituto-tecnico-belleza-integral-alfred',
        ])->delete();

        $raulPrada = $this->artistic($department->id, 'instituto-formacion-artistica-raul-g-prada', 'Instituto de Formación Artística Artes Plásticas Raúl G. Prada', 'Cochabamba', 'Calle Bartolomé Guzmán N.º 717, Coronilla de San Sebastián', '4580059', ['artes-plasticas-y-visuales']);
        $raulPrada->update(['description' => 'Instituto fiscal especializado en artes plásticas y visuales, con formación técnica y capacitación artística en la histórica zona de la Coronilla.']);
        Institution::where('slug', 'academia-nacional-musica-man-cesped')->delete();
        $eduardoLaredo = $this->artistic($department->id, 'instituto-educacion-integral-eduardo-laredo', 'Instituto de Educación Integral y Formación Artística Eduardo Laredo', 'Cochabamba', 'Av. Ramón Rivero N.º 3050', '4255963 / 4117399', ['musica','danza','teatro']);
        $eduardoLaredo->update(['description' => 'Institución fiscal de educación integral y formación artística que reúne música, danza y teatro en niveles técnicos.']);
        DB::table('institution_career')->where('institution_id', $eduardoLaredo->id)->update(['degree_level' => 'Técnico Medio y Superior', 'duration_text' => '2 a 3 años según nivel']);
        Institution::whereIn('slug', [
            'instituto-formacion-artistica-8-de-julio',
            'club-bambi-bengolea-escuela-futbol',
            'glamour-models-academia-modelaje',
            'leire-models-academia-modelaje',
            'jl-escuela-internacional-modelaje',
            'merak-escuela-modelaje',
        ])->delete();

        $verifiedUmssDurations = ['administracion-de-empresas'=>'5 años','administracion-rural'=>'3 años','antropologia-y-arqueologia'=>'5 años','arquitectura'=>'5 años','biologia'=>'5 años','bioquimica'=>'5 años','ciencias-de-la-educacion'=>'5 años','derecho'=>'5 años','trabajo-social'=>'4 años y medio'];
        foreach ($verifiedUmssDurations as $slug => $duration) {
            $careerId = Career::where('slug', $slug)->value('id');
            if ($careerId) DB::table('institution_career')->where('institution_id', $umss->id)->where('career_id', $careerId)->update(['duration_text' => $duration]);
        }
    }

    private function institution(int $departmentId, string $slug, array $data): Institution
    {
        return Institution::updateOrCreate(['slug' => $slug], $data + ['department_id' => $departmentId, 'verified_at' => now(), 'is_verified' => true, 'is_active' => true]);
    }

    private function unit(Institution $institution, string $name, string $type, int $order): void
    {
        InstitutionUnit::updateOrCreate(['institution_id' => $institution->id, 'slug' => Str::slug($name)], ['name' => $name, 'unit_type' => $type, 'sort_order' => $order, 'is_active' => true]);
    }

    private function attach(Institution $institution, string $unitName, array $slugs): void
    {
        $unit = InstitutionUnit::where('institution_id', $institution->id)->where('slug', Str::slug($unitName))->firstOrFail();
        foreach (Career::whereIn('slug', $slugs)->get() as $career) $institution->careers()->syncWithoutDetaching([$career->id => ['institution_unit_id' => $unit->id, 'degree_level' => $career->degree_level, 'modality' => 'Presencial', 'schedule' => 'Consultar con la institución', 'duration_text' => $career->duration_text, 'labor_demand' => 'Variado', 'labor_demand_notes' => null, 'is_active' => true]]);
    }

    private function technical(int $departmentId, string $slug, string $name, string $city, string $address, ?string $phone, array $slugs, string $schedule): void
    {
        $institution = $this->institution($departmentId, $slug, [
            'name' => $name, 'institution_type' => 'Instituto técnico/tecnológico', 'ownership' => 'Fiscal', 'payment_type' => 'Gratuita',
            'description' => "Instituto fiscal de formación técnica superior ubicado en {$city}. Su oferta está orientada a la preparación práctica en ".count($slugs).' áreas técnicas vinculadas con las necesidades productivas y de servicios de su municipio.',
            'cost_notes' => 'Formación fiscal; confirmar valores administrativos, materiales y requisitos directamente con el instituto.',
            'schedule_notes' => $schedule, 'city' => $city, 'address' => $address, 'phone' => $phone,
            'source_url' => null,
        ]);
        foreach (Career::whereIn('slug', $slugs)->get() as $career) $institution->careers()->syncWithoutDetaching([$career->id => [
            'degree_level' => 'Técnico Superior', 'modality' => 'Presencial', 'schedule' => $schedule,
            'duration_text' => '3 años', 'labor_demand' => 'Variado', 'labor_demand_notes' => null, 'is_active' => true,
        ]]);
    }

    private function convenio(int $departmentId, string $slug, string $name, string $city, string $address, ?string $phone, array $slugs): Institution
    {
        $this->technical($departmentId, $slug, $name, $city, $address, $phone, $slugs, 'Consultar');
        $institution = Institution::where('slug', $slug)->firstOrFail();
        $institution->update(['ownership' => 'De convenio', 'payment_type' => 'Mixta', 'description' => 'Instituto de convenio autorizado y registrado por el Ministerio de Educación.']);
        return $institution;
    }

    private function privateTechnical(int $departmentId, string $slug, string $name, string $city, string $address, ?string $phone, array $slugs): Institution
    {
        $this->technical($departmentId, $slug, $name, $city, $address, $phone, $slugs, 'Consultar');
        $institution = Institution::where('slug', $slug)->firstOrFail();
        $institution->update(['ownership' => 'Privada', 'payment_type' => 'De pago']);
        return $institution;
    }

    private function university(int $departmentId, string $slug, string $name, string $acronym, string $address, string $website, array $groups): Institution
    {
        $institution = $this->institution($departmentId, $slug, [
            'name' => $name, 'acronym' => $acronym, 'institution_type' => 'Universidad', 'ownership' => 'Privada', 'payment_type' => 'De pago',
            'description' => "Universidad privada con sede o campus en Cochabamba y una oferta organizada en ".count($groups).' áreas académicas.',
            'cost_notes' => 'Los aranceles y modalidades de pago deben consultarse con Admisiones.', 'schedule_notes' => 'Los horarios varían según carrera y semestre.',
            'city' => 'Cochabamba', 'address' => $address, 'website' => $website, 'source_url' => $website,
        ]);
        foreach ($groups as $position => $slugs) { $this->unit($institution, $position, 'Área académica', array_search($position, array_keys($groups)) + 1); $this->attach($institution, $position, $slugs); }
        return $institution;
    }

    private function artistic(int $departmentId, string $slug, string $name, string $city, string $address, ?string $phone, array $slugs): Institution
    {
        $institution = $this->institution($departmentId, $slug, ['name' => $name, 'institution_type' => 'Instituto artístico', 'ownership' => 'Fiscal', 'payment_type' => 'Gratuita', 'description' => 'Institución fiscal de formación artística.', 'cost_notes' => 'Confirmar materiales y valores administrativos con la institución.', 'schedule_notes' => 'Consultar', 'city' => $city, 'address' => $address, 'phone' => $phone, 'source_url' => null]);
        $this->attachDirect($institution, $slugs, 'Consultar');
        return $institution;
    }

    private function modelingAcademy(int $departmentId, string $slug, string $name, string $address, ?string $phone, string $schedule): Institution
    {
        $institution = $this->institution($departmentId, $slug, [
            'name' => $name, 'institution_type' => 'Academia de modelaje', 'ownership' => 'Privada', 'payment_type' => 'De pago',
            'description' => 'Academia cochabambina orientada a la formación integral en modelaje, presencia escénica y proyección personal.',
            'cost_notes' => 'Consultar matrícula, mensualidad y duración directamente con la academia.', 'schedule_notes' => $schedule,
            'is_single_program' => true, 'specialty_areas' => ['Pasarela y desplazamiento','Expresión corporal','Pose y fotografía','Imagen personal','Protocolo y presencia escénica','Autoestima y proyección personal'],
            'city' => 'Cochabamba', 'address' => $address, 'phone' => $phone, 'source_url' => null, 'is_verified' => false, 'verified_at' => null,
        ]);
        $this->attachDirect($institution, ['modelaje-profesional'], $schedule);
        DB::table('institution_career')->where('institution_id', $institution->id)->update(['duration_text' => 'Consultar con la academia']);
        return $institution;
    }

    private function ensureCareer(string $slug, string $name, string $summary): void
    {
        Career::updateOrCreate(['slug' => $slug], ['academic_area_id' => AcademicArea::where('slug', 'arte-diseno-y-arquitectura')->value('id'), 'name' => $name, 'degree_level' => 'Formación especializada', 'duration_text' => null, 'is_traditional' => false, 'summary' => $summary, 'description' => $summary, 'is_active' => true]);
    }

    private function attachDirect(Institution $institution, array $slugs, string $schedule): void
    {
        foreach (Career::whereIn('slug', $slugs)->get() as $career) $institution->careers()->syncWithoutDetaching([$career->id => [
            'degree_level' => 'Técnico Superior', 'modality' => 'Presencial', 'schedule' => $schedule,
            'duration_text' => '3 años', 'labor_demand' => 'Variado', 'labor_demand_notes' => null, 'is_active' => true,
        ]]);
    }
}
