<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AcademicCatalogSeeder::class);
        $this->call(TraditionalCareersSeeder::class);
        $this->call(VerifiedNationalCareersSeeder::class);
        $this->call(CochabambaInstitutionsSeeder::class);
        $this->call(LaPazInstitutionsSeeder::class);
        $this->call(SantaCruzInstitutionsSeeder::class);
        $this->call(PandoInstitutionsSeeder::class);
        $this->call(BeniInstitutionsSeeder::class);
        $this->call(ChuquisacaInstitutionsSeeder::class);
        $this->call(TarijaInstitutionsSeeder::class);
        $this->call(PotosiInstitutionsSeeder::class);
        $this->call(OruroInstitutionsSeeder::class);
        $this->call(TeacherTrainingSeeder::class);
        $this->call(AdditionalCochabambaUniversitiesSeeder::class);

        // Una ubicación municipal aproximada sirve para orientar la búsqueda,
        // pero no debe presentarse al usuario como una dirección ya verificada.
        Institution::query()
            ->where(function ($query) {
                $query->where('address', 'like', 'Zona Central%')
                    ->orWhere('address', 'like', 'Ciudad de %')
                    ->orWhere('address', 'like', 'Municipio de %');
            })
            ->update(['is_verified' => false, 'verified_at' => null]);

        $this->call(InstitutionCareerCatalogSeeder::class);
        $this->call(CareerContentEnrichmentSeeder::class);
        $this->call(NonTraditionalCareersSeeder::class);
        $this->call(CreativeNonTraditionalCareersSeeder::class);
        $this->call(CareerDefinitionsSeeder::class);
        $this->call(CareerProfessionalProfilesSeeder::class);
        $this->call(OpportunitiesSeeder::class);
        $this->call(InstitutionConsolidationSeeder::class);
        $this->call(UdabolAdditionalCampusesSeeder::class);
        $this->call(RemoveUnconfirmedInstitutionsSeeder::class);
        $this->call(InstitutionContactDetailsSeeder::class);
        $this->call(AcademicOfferingDefaultsSeeder::class);
        $this->call(InstitutionSocialLinksSeeder::class);
    }
}
