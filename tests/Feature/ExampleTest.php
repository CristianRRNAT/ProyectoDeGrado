<?php

namespace Tests\Feature;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Encuentra el camino');
        $response->assertSee('Test vocacional');
    }

    public function test_instituto_tecnologico_sacaba_page_is_available(): void
    {
        $department = Department::create(['name' => 'Cochabamba', 'slug' => 'cochabamba', 'capital' => 'Cochabamba', 'is_active' => true]);
        $institution = Institution::create(['department_id' => $department->id, 'name' => 'Instituto Tecnológico Sacaba', 'slug' => 'instituto-tecnologico-sacaba', 'institution_type' => 'Instituto técnico', 'city' => 'Sacaba', 'address' => 'Sacaba', 'is_active' => true]);
        $career = Career::create(['name' => 'Sistemas Informáticos', 'slug' => 'sistemas-informaticos', 'degree_level' => 'Técnico Superior', 'summary' => 'Formación tecnológica.', 'is_active' => true]);
        $institution->careers()->attach($career->id, ['is_active' => true]);

        $response = $this->actingAs(User::factory()->create())->get('/instituciones/instituto-tecnologico-sacaba');

        $response->assertStatus(200);
        $response->assertSee('Instituto Tecnológico Sacaba');
        $response->assertSee('Sistemas Informáticos');
        $response->assertSee('Google Maps');
    }

    public function test_guests_see_only_institution_name_and_department(): void
    {
        $department = Department::create(['name' => 'Cochabamba', 'slug' => 'cochabamba', 'capital' => 'Cochabamba', 'is_active' => true]);
        $institution = Institution::create([
            'department_id' => $department->id, 'name' => 'Instituto de Prueba',
            'slug' => 'instituto-de-prueba', 'institution_type' => 'Instituto técnico',
            'city' => 'Sacaba', 'address' => 'Dirección privada 123',
            'description' => 'Descripción que no debe aparecer para visitantes.', 'is_active' => true,
        ]);

        $this->get(route('institutions.index'))
            ->assertOk()
            ->assertSee('Instituto de Prueba')
            ->assertSee('Cochabamba')
            ->assertDontSee('Dirección privada 123')
            ->assertDontSee('Descripción que no debe aparecer para visitantes.');

        $this->get(route('institutions.show', $institution))->assertRedirect(route('login'));
    }

    public function test_route_planner_receives_every_institution_campus(): void
    {
        $department = Department::create(['name' => 'La Paz', 'slug' => 'la-paz', 'capital' => 'La Paz', 'is_active' => true]);
        $institution = Institution::create([
            'department_id' => $department->id,
            'name' => 'Universidad con varias sedes',
            'slug' => 'universidad-con-varias-sedes',
            'institution_type' => 'Universidad',
            'city' => 'La Paz',
            'address' => 'Sede principal, La Paz',
            'campuses' => [
                ['name' => 'Sede El Alto', 'city' => 'El Alto', 'department' => 'La Paz', 'address' => 'El Alto'],
                ['name' => 'Sede Cochabamba', 'city' => 'Cochabamba', 'department' => 'Cochabamba', 'address' => 'Cochabamba'],
            ],
            'is_active' => true,
        ]);

        $this->actingAs(User::factory()->create())
            ->get(route('institutions.show', $institution))
            ->assertOk()
            ->assertViewHas('institutionRouteData', fn (array $data) =>
                $data['enabled'] === true
                && count($data['locations']) === 3
                && $data['locations'][1]['name'] === 'Sede El Alto'
                && $data['locations'][2]['department'] === 'Cochabamba'
            );
    }

    public function test_users_can_submit_moderated_institution_comments_and_like_approved_ones(): void
    {
        $department = Department::create(['name' => 'Cochabamba', 'slug' => 'cochabamba', 'capital' => 'Cochabamba', 'is_active' => true]);
        $institution = Institution::create([
            'department_id' => $department->id,
            'name' => 'Institución comentable',
            'slug' => 'institucion-comentable',
            'institution_type' => 'Instituto técnico',
            'city' => 'Cochabamba',
            'address' => 'Dirección de prueba',
            'is_active' => true,
        ]);
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('comments.store'), [
            'institution_id' => $institution->id,
            'content' => 'La atención fue clara y me ayudó con la inscripción.',
        ])->assertSessionHas('status');

        $pending = Comment::firstOrFail();
        $this->assertSame('pending', $pending->status);
        $this->actingAs($user)->get(route('institutions.show', $institution))->assertDontSee($pending->content);

        $pending->update(['status' => 'approved', 'reviewed_at' => now()]);
        $this->actingAs($user)->get(route('institutions.show', $institution))->assertSee($pending->content);
        $this->actingAs($user)->post(route('comments.like', $pending))->assertRedirect();
        $this->assertDatabaseHas('comment_likes', ['comment_id' => $pending->id, 'user_id' => $user->id]);
    }
}
