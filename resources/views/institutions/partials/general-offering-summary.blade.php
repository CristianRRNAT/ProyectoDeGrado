@php
    $generalOffering = ($careersByUnit['direct'] ?? collect())->first();
    $generalFacts = [
        ['label' => 'Duración', 'value' => $generalOffering?->pivot?->duration_text ?: $generalOffering?->duration_text ?: 'Consultar'],
        ['label' => 'Horario', 'value' => $generalOffering?->pivot?->schedule ?: $institution->schedule_notes ?: 'Consultar'],
        ['label' => 'Régimen', 'value' => $generalOffering?->pivot?->academic_regime ?: 'Semestral'],
        ['label' => 'Modalidad', 'value' => $generalOffering?->pivot?->modality ?: 'Presencial'],
        ['label' => 'Campo laboral', 'value' => $generalOffering?->pivot?->labor_demand ?: 'Variado'],
    ];
@endphp

<div class="general-offering-summary" aria-label="Información general del programa">
    @foreach($generalFacts as $fact)
        <div class="general-offering-fact">
            <small>{{ Str::upper($fact['label']) }}</small>
            <strong>{{ $fact['value'] }}</strong>
        </div>
    @endforeach
</div>