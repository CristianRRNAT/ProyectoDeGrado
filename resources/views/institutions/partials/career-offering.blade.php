@php
    $isItsaNightProgram = $institution->slug === 'instituto-tecnologico-sacaba'
        && in_array($career->slug, [
            'informatica-industrial',
            'mecanica-automotriz',
            'secretariado-ejecutivo',
            'sistemas-informaticos',
            'topografia-y-geodesia',
        ], true);
@endphp
<details class="career-offering">
    <summary>
        <span><strong>{{ $career->name }}</strong><small>{{ $career->pivot->degree_level ?? $career->degree_level }}</small></span>
        <span class="expand-label">Ver datos</span>
    </summary>
    <div class="offering-details">
        <div><small>DURACIÓN</small><strong>{{ $career->pivot->duration_text ?: '3 años aprox.' }}</strong></div>
        <div><small>HORARIO</small><strong>{{ $isItsaNightProgram ? 'Noche' : ($career->pivot->schedule ?: 'Mañana y noche') }}</strong></div>
        <div><small>RÉGIMEN</small><strong>{{ $career->pivot->academic_regime ?: (str_contains(mb_strtolower($institution->institution_type), 'universidad') ? 'Semestral' : 'Anual') }}</strong></div>
        <div><small>MODALIDAD</small><strong>{{ $career->pivot->modality ?: 'Presencial' }}</strong></div>
        <div><small>CAMPO LABORAL</small><strong class="demand">{{ $career->pivot->labor_demand ?: 'Variado' }}</strong></div>
        @if($career->pivot->labor_demand_notes)<p>{{ $career->pivot->labor_demand_notes }}</p>@endif
        @if($career->pivot->details_source_url)<a href="{{ $career->pivot->details_source_url }}" target="_blank" rel="noopener noreferrer">Consultar plan o fuente oficial</a>@endif
        <a href="{{ route('careers.show',$career) }}">Saber más de la carrera →</a>
    </div>
</details>
