<?php

namespace Tests\Feature;

use App\Models\Career;
use App\Models\User;
use App\Models\VocationalTestResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompleteVocationalTestTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('test.complete'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_sees_personal_greeting_and_thirty_questions(): void
    {
        $user = User::factory()->make(['name' => 'María López']);

        $this->actingAs($user)
            ->get(route('test.complete'))
            ->assertOk()
            ->assertSee('Hola, María')
            ->assertSee('Pregunta <i data-current>1</i> de 30', false);
    }

    public function test_login_and_registration_pages_are_available(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Iniciar sesión');
        $this->get(route('register'))->assertOk()->assertSee('Crear una cuenta');
    }

    public function test_answers_are_saved_with_five_recommendations_and_pdf_is_generated(): void
    {
        $user = User::factory()->create();
        foreach (range(1, 5) as $number) {
            Career::create([
                'name' => 'Carrera de prueba '.$number,
                'slug' => 'carrera-prueba-'.$number,
                'degree_level' => 'Licenciatura',
                'summary' => 'Una opción profesional utilizada para comprobar las recomendaciones.',
                'riasec_primary' => 'R',
                'riasec_secondary' => 'I',
            ]);
        }

        $response = $this->actingAs($user)->post(route('test.complete.store'), [
            'answers' => array_fill(0, 30, 3),
        ]);

        $result = VocationalTestResult::firstOrFail();
        $response->assertRedirect(route('test.results.show', $result));
        $this->assertCount(5, $result->recommended_career_ids);
        $this->get(route('test.results.pdf', $result))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }
}
