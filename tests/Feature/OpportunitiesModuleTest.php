<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OpportunitiesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpportunitiesModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_module_requires_an_authenticated_user(): void
    {
        $this->get(route('opportunities.index'))->assertRedirect(route('login'));
    }

    public function test_courses_trainings_scholarships_and_videos_are_available(): void
    {
        $this->seed(OpportunitiesSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('opportunities.index', ['type'=>'course']))
            ->assertOk()->assertSee('Moderna Dallas')->assertSee('APRENDE EN LÍNEA');
        $this->get(route('opportunities.index', ['type'=>'training']))
            ->assertOk()->assertSee('Aduana Nacional');
        $this->get(route('opportunities.index', ['type'=>'scholarship']))
            ->assertOk()->assertSee('5.000 Becas Google');
    }

    public function test_an_authenticated_organization_can_submit_an_opportunity_for_review(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('opportunities.submissions.store'), [
            'full_name' => 'María López',
            'email' => 'maria@example.com',
            'phone' => '70700000',
            'organization_type' => 'academy',
            'organization_name' => 'Academia Ejemplo',
            'opportunity_type' => 'course',
        ])->assertSessionHas('submission_success');

        $this->assertDatabaseHas('opportunity_submissions', [
            'user_id' => $user->id,
            'organization_name' => 'Academia Ejemplo',
            'status' => 'pending',
        ]);
    }

    public function test_cochabamba_cba_and_youth_house_are_listed(): void
    {
        $this->seed(OpportunitiesSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('opportunities.index', ['type' => 'course']))
            ->assertOk()
            ->assertSee('Centro Boliviano Americano — Cochabamba')
            ->assertSee('Casa Municipal de la Juventud de Cochabamba');
    }
}
