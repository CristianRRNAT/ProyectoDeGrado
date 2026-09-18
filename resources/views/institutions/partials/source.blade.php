@php
    $officialWebsite = filled($institution->website)
        && !preg_match('/(^|\.)facebook\.com$/i', parse_url($institution->website, PHP_URL_HOST) ?? '');
@endphp
<div class="source-note">
    <div>
        <small>FUENTE Y CONFIRMACIÓN</small>
        <strong>Información oficial de la institución</strong>
        <p>{{ $officialWebsite ? 'Consulta la página web oficial para confirmar convocatorias y datos vigentes.' : 'Esta institución no tiene una página web oficial registrada.' }}</p>
    </div>
    @if($officialWebsite)
        <a href="{{ $institution->website }}" target="_blank" rel="noopener noreferrer">Consultar fuente</a>
    @else
        <span class="source-unavailable">Página oficial no disponible</span>
    @endif
</div>
