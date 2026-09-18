<article class="contact-card">
    <span class="section-kicker">DATOS DE CONTACTO</span>
    <h2>Información institucional</h2>
    <ul>
        <li class="contact-address">
            <i aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 21s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12Z"/><circle cx="12" cy="9" r="2.5"/></svg></i>
            <div><small>DIRECCIÓN</small><strong data-institution-address>@if($hasMultipleLocations)<span data-address-line>Escoge una sede</span><br><span data-address-location>Selecciona una ubicación en “Sedes registradas”.</span>@else<span data-address-line>{{ $institution->address ?: 'Dirección por confirmar' }}</span><br><span data-address-location>{{ $institution->city }}, {{ $institution->department->name }}</span>@endif</strong></div>
        </li>
        @if($institution->phone)
            <li class="contact-phone"><i aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M7.1 3.5 4.6 5.2c-.8.6-.9 1.7-.6 2.6 2.1 5.9 6.3 10.1 12.2 12.2.9.3 2 .2 2.6-.6l1.7-2.5c.4-.6.3-1.4-.3-1.8l-3.4-2.3c-.5-.3-1.2-.3-1.6.2l-1.4 1.5a12.2 12.2 0 0 1-4.3-4.3L11 8.8c.5-.4.5-1.1.2-1.6L8.9 3.8c-.4-.6-1.2-.7-1.8-.3Z"/></svg></i><div><small>TELÉFONO</small>@foreach(explode('/', $institution->phone) as $phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $phone) }}">{{ trim($phone) }}</a>@unless($loop->last)<br>@endunless @endforeach</div></li>
        @endif
        @if($institution->email)
            <li><i aria-hidden="true">✉</i><div><small>CORREO</small><a href="mailto:{{ $institution->email }}">{{ $institution->email }}</a></div></li>
        @endif
    </ul>

    <div class="institution-socials">
        <small>CANALES OFICIALES</small>
        <div class="social-links">
            @if($institution->whatsapp_url)<a class="social-whatsapp" href="{{ $institution->whatsapp_url }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp oficial"><svg viewBox="0 0 24 24"><path d="M20.5 11.7a8.5 8.5 0 0 1-12.6 7.5L3 20.5l1.3-4.7a8.5 8.5 0 1 1 16.2-4.1Z"/><path d="M8.4 7.6c.2-.4.4-.4.7-.4h.5c.2 0 .4.1.5.5l.7 1.8c.1.3 0 .5-.2.7l-.6.7c-.2.2-.1.4 0 .6.8 1.4 1.9 2.5 3.4 3.2.2.1.4.1.6-.1l.8-1c.2-.2.4-.3.7-.2l1.8.8c.3.1.5.3.5.5 0 .3-.1 1.5-.7 2.1-.6.6-1.6.9-2.6.7-1.2-.2-2.7-.8-4.5-2.3-2.1-1.8-3.4-4-3.8-5.3-.4-1.2 0-2 .2-2.3Z"/></svg><span>WhatsApp</span></a>@endif
            @if($institution->facebook_url)<a class="social-facebook" href="{{ $institution->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook oficial"><svg viewBox="0 0 24 24"><path d="M14 8h3V4h-3c-3.4 0-5 2-5 5v2H6v4h3v7h4v-7h3.3l.7-4h-4V9c0-.7.3-1 1-1Z"/></svg><span>Facebook</span></a>@endif
            @if($institution->tiktok_url)<a class="social-tiktok" href="{{ $institution->tiktok_url }}" target="_blank" rel="noopener noreferrer" aria-label="TikTok oficial"><svg viewBox="0 0 24 24"><path d="M14 3v11.2a4.2 4.2 0 1 1-3.4-4.1v3a1.4 1.4 0 1 0 .6 1.1V3h2.8c.5 2.2 1.8 3.5 4 3.9v3c-1.6-.2-2.9-.8-4-1.7"/></svg><span>TikTok</span></a>@endif
            @unless($institution->whatsapp_url || $institution->facebook_url || $institution->tiktok_url)<p>No hay canales sociales oficiales registrados.</p>@endunless
        </div>
    </div>
</article>
