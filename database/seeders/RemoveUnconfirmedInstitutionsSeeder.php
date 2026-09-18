<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemoveUnconfirmedInstitutionsSeeder extends Seeder
{
    public function run(): void
    {
        // Lista fija de las 29 instituciones retiradas por solicitud del usuario.
        // No eliminar automáticamente nuevas instituciones que aún no tengan imágenes.
        $slugs = json_decode(file_get_contents(database_path('data/removed-unconfirmed-institutions.json')), true, 512, JSON_THROW_ON_ERROR);
        DB::transaction(fn () => Institution::whereIn('slug', $slugs)->delete());
    }
}