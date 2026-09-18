<div class="directory-map-modal" data-directory-map-modal hidden>
    <div class="directory-map-dialog" role="dialog" aria-modal="true" aria-labelledby="directory-map-title">
        <header>
            <div><span>DIRECTORIO GEOGRÁFICO</span><h2 id="directory-map-title">Instituciones en Bolivia</h2><p>Selecciona un departamento para mostrar todas sus instituciones y sedes registradas.</p></div>
            <button type="button" aria-label="Cerrar mapa" data-directory-map-close>×</button>
        </header>
        <div class="directory-map-controls">
            <label for="directory-map-department">Departamento</label>
            <select id="directory-map-department" data-directory-map-department>
                <option value="">Vista general de Bolivia</option>
                @foreach($departments as $department)<option value="{{ $department->slug }}">{{ $department->name }}</option>@endforeach
            </select>
            <span data-directory-map-status>Selecciona un departamento para explorar sus instituciones.</span>
        </div>
        <div class="directory-map-canvas" data-directory-map-canvas><div class="directory-map-loading">Cargando mapa de Bolivia…</div></div>
    </div>
</div>
<script>window.directoryInstitutionMapData=@json($directoryMapInstitutions);window.directoryGoogleMapsKey=@json(config('services.google_maps.key'));</script>
<script src="{{ asset('js/institution-directory-map.js') }}?v=3"></script>
