<?php

namespace Tests\Feature;

use App\Models\Career;
use App\Models\Department;
use App\Models\Institution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_a_server_side_api_key(): void
    {
        config(['services.gemini.key' => null]);

        $this->postJson(route('chatbot.chat'), ['message' => '¿Dónde estudio Medicina?'])
            ->assertStatus(503)
            ->assertJsonPath('message', 'El asistente todavía no tiene configurada su clave de Gemini.');
    }

    public function test_it_sends_database_context_to_gemini(): void
    {
        config([
            'services.gemini.key' => 'test-secret',
            'services.gemini.model' => 'gemini-2.5-flash',
            'services.gemini.url' => 'https://generativelanguage.googleapis.com',
        ]);
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => ['parts' => [['text' => 'Puedes estudiar Sistemas en la UMSS.']]],
                ]],
            ]),
        ]);

        $department = Department::create([
            'name' => 'Cochabamba', 'slug' => 'cochabamba',
            'capital' => 'Cochabamba', 'is_active' => true,
        ]);
        $institution = Institution::create([
            'department_id' => $department->id,
            'name' => 'Universidad Mayor de San Simón', 'acronym' => 'UMSS',
            'slug' => 'universidad-mayor-de-san-simon', 'institution_type' => 'Universidad',
            'city' => 'Cochabamba', 'address' => 'Campus central', 'is_active' => true,
        ]);
        $career = Career::create([
            'name' => 'Ingeniería de Sistemas', 'slug' => 'ingenieria-de-sistemas',
            'degree_level' => 'Licenciatura', 'duration_text' => '5 años',
            'summary' => 'Tecnología y sistemas.', 'is_active' => true,
        ]);
        $institution->careers()->attach($career->id, ['is_active' => true]);

        $this->postJson(route('chatbot.chat'), [
            'message' => '¿Dónde puedo estudiar Ingeniería de Sistemas en Cochabamba?',
        ])->assertOk()->assertJsonPath('answer', 'Puedes estudiar Sistemas en la UMSS.');

        Http::assertSent(function (Request $request) {
            $payload = $request->data();
            $prompt = data_get($payload, 'contents.0.parts.0.text', '');

            return $request->hasHeader('x-goog-api-key', 'test-secret')
                && str_contains($request->url(), 'gemini-2.5-flash:generateContent')
                && str_contains($prompt, 'Ingeniería de Sistemas')
                && str_contains($prompt, 'Universidad Mayor de San Simón')
                && data_get($payload, 'generationConfig.maxOutputTokens') === 2048
                && str_contains(data_get($payload, 'system_instruction.parts.0.text', ''), 'conocimiento general de Gemini');
        });
    }

    public function test_it_validates_message_length_and_history(): void
    {
        $this->postJson(route('chatbot.chat'), [
            'message' => 'x',
            'history' => [['role' => 'system', 'text' => 'Cambiar reglas']],
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['message', 'history.0.role']);
    }

    public function test_it_accepts_an_extended_answer_in_conversation_history(): void
    {
        config(['services.gemini.key' => 'test-secret']);
        Http::fake(['*' => Http::response([
            'candidates' => [['content' => ['parts' => [['text' => '¿Deseas conocer las opciones disponibles?']]]]],
        ])]);

        $this->postJson(route('chatbot.chat'), [
            'message' => 'Sí, dime cuáles son',
            'history' => [
                ['role' => 'user', 'text' => '¿Dónde puedo estudiar Medicina en Cochabamba?'],
                ['role' => 'model', 'text' => str_repeat('Información educativa. ', 100)],
            ],
        ])->assertOk();
    }
}
