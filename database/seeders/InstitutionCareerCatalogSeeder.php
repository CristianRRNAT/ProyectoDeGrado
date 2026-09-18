<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;

class InstitutionCareerCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // El catálogo conserva únicamente carreras con oferta institucional.
        Career::query()
            ->where('is_traditional', true)
            ->whereDoesntHave('institutions', function ($query) {
                $query->where('institutions.is_active', true)
                    ->where('institution_career.is_active', true);
            })
            ->delete();

        Career::query()->update(['is_active' => true]);
    }
}
