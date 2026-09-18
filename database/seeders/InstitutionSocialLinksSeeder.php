<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionSocialLinksSeeder extends Seeder
{
    public function run(): void
    {
        $verifiedFacebookPages = [
            'academia-nacional-de-policias-anapol' => 'https://www.facebook.com/490073877520235',
            'centro-formacion-profesional-brasil-bolivia' => 'https://www.facebook.com/InstitutoTecnologicoIndustrialBrasilBolivia',
            'conservatorio-plurinacional-musica' => 'https://www.facebook.com/COPLUMU',
            'escuela-naval-militar-eduardo-avaroa' => 'https://www.facebook.com/343567245500107',
            'esfm-simon-rodriguez-cochabamba' => 'https://www.facebook.com/242121885640971',
            'fatescipol' => 'https://www.facebook.com/117078210137675',
            'instituto-politécnico-tomas-katari' => 'https://www.facebook.com/ONG.IPTK.BOLIVIA',
            'instituto-tecnico-educacion-comercial-americano' => 'https://www.facebook.com/ITECA',
            'instituto-tecnologico-agropecuario-industrial-tarata' => 'https://www.facebook.com/105218268729698',
            'instituto-tecnologico-avelino-sinani-de-mizque' => 'https://www.facebook.com/ISTASMIZQUE',
            'instituto-tecnologico-mineros-san-juan' => 'https://www.facebook.com/61550046909786',
            'instituto-tecnologico-padre-antonio-berta' => 'https://www.facebook.com/251913285544851',
            'instituto-tecnologico-presidente-evo-morales-ayma' => 'https://www.facebook.com/513147176253641',
            'universidad-autonoma-juan-misael-saracho' => 'https://www.facebook.com/uajms',
            'universidad-cristiana-de-bolivia' => 'https://www.facebook.com/ucebol.info',
            'universidad-de-aquino-bolivia' => 'https://www.facebook.com/289854214378057',
            'universidad-publica-de-el-alto' => 'https://www.facebook.com/upea.comunicacion',
            'universidad-tecnologica-privada-santa-cruz' => 'https://www.facebook.com/UTEPSA',
        ];

        foreach ($verifiedFacebookPages as $slug => $facebookUrl) {
            DB::table('institutions')->where('slug', $slug)->update(['facebook_url' => $facebookUrl]);
        }

        $verifiedTikTokPages = [
            'centro-formacion-profesional-brasil-bolivia' => 'https://www.tiktok.com/@itibb_digital',
            'instituto-tecnologico-jose-castillo-fe-alegria' => 'https://www.tiktok.com/@ITSJC_Oficial',
            'instituto-tecnologico-latinoamericano-tel' => 'https://www.tiktok.com/@instituto.latinomericano',
            'universidad-catolica-boliviana-san-pablo' => 'https://www.tiktok.com/@lacato_',
            'universidad-cristiana-de-bolivia' => 'https://www.tiktok.com/@universidad_ucebol',
            'universidad-de-aquino-bolivia' => 'https://www.tiktok.com/@udaboloficial',
            'universidad-mayor-de-san-andres' => 'https://www.tiktok.com/@umsa.bo',
            'universidad-mayor-de-san-simon' => 'https://www.tiktok.com/@umssdigital',
            'universidad-privada-boliviana' => 'https://www.tiktok.com/@upbcbba',
        ];

        foreach ($verifiedTikTokPages as $slug => $tiktokUrl) {
            DB::table('institutions')->where('slug', $slug)->update(['tiktok_url' => $tiktokUrl]);
        }

        DB::table('institutions')->where('website', 'like', '%facebook.com%')->orderBy('id')->each(function ($institution) {
            DB::table('institutions')->where('id', $institution->id)->update([
                'facebook_url' => $institution->facebook_url ?: $institution->website,
                'website' => null,
            ]);
        });
    }
}
