<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InstitutionContactDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $entries = json_decode(file_get_contents(database_path('data/institution-contact-updates.json')), true, 512, JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($entries) {
            foreach ($entries as $entry) {
                $institution = Institution::where('slug', $entry['slug'])->where('is_active', true)->first();
                if (!$institution) {
                    continue;
                }

                $changes = Arr::only($entry, ['address', 'city', 'phone', 'website']);
                // Una dirección nueva no debe conservar coordenadas de la ubicación anterior.
                if ((isset($changes['address']) && $changes['address'] !== $institution->address)
                    || (isset($changes['city']) && $changes['city'] !== $institution->city)) {
                    $changes['latitude'] = null;
                    $changes['longitude'] = null;
                }
                $institution->fill($changes);
                if ($institution->isDirty()) {
                    $institution->save();
                }
            }
        });
    }
}