<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\InstitutionConsolidationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncosConsolidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_incos_has_eight_locations_and_remains_unique_after_consolidating_again(): void
    {
        $this->seed(DatabaseSeeder::class);
        $institution = Institution::where('slug', 'incos')->firstOrFail();
        $this->assertSame(1, Institution::where('name', 'like', '%INCOS%')->count());
        $this->assertCount(7, $institution->campuses);
        $careerIds = $institution->careers()->pluck('careers.id')->sort()->values()->all();
        $this->assertNotEmpty($careerIds);

        $this->seed(InstitutionConsolidationSeeder::class);
        $institution->refresh();
        $this->assertCount(7, $institution->campuses);
        $this->assertSame($careerIds, $institution->careers()->pluck('careers.id')->sort()->values()->all());

        $response = $this->actingAs(User::factory()->create())->get(route('institutions.show', $institution));
        $response->assertOk()->assertSee('Total de sedes: 8');
        $response->assertViewHas('mapLocations', fn ($locations) => $locations->count() === 8);
        $about = explode('<article class="info-card" id="oferta">', $response->getContent())[0];
        foreach (['La Paz', 'Quillacollo', 'Tarija', 'Potosí', 'Cobija', 'Trinidad', 'Guayaramerín', 'Santa Ana del Yacuma'] as $city) {
            $this->assertStringContainsString('Sede '.$city, $about);
        }
        foreach (['la-paz', 'cochabamba', 'tarija', 'potosi', 'pando', 'beni'] as $department) {
            $this->get(route('institutions.index', ['department' => $department, 'q' => 'INCOS']))
                ->assertOk()->assertSee($institution->name);
        }
    }
}