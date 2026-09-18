<article class="institution-comments-card" data-institution-comments>
    <div class="comments-heading">
        <div><span>COMUNIDAD</span><h3>Comentarios</h3></div>
        @if($institutionComments->isNotEmpty())<small><b data-comment-current>1</b>/{{ $institutionComments->count() }}</small>@endif
    </div>

    <div class="institution-comment-track">
        @forelse($institutionComments as $comment)
            @php($initials = collect(explode(' ', trim($comment->user->name)))->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join(''))
            <article class="institution-comment {{ $loop->first ? 'is-active' : '' }}" data-comment-slide>
                <div class="comment-avatar">
                    @if($comment->user->avatar_url)<img src="{{ $comment->user->avatar_url }}" alt="Foto de {{ $comment->user->name }}" referrerpolicy="no-referrer">@else<span>{{ $initials }}</span>@endif
                </div>
                <div class="comment-copy"><strong>{{ $comment->user->name }}</strong><p>{{ $comment->content }}</p><small>{{ $comment->reviewed_at?->diffForHumans() ?? $comment->created_at->diffForHumans() }}</small></div>
                <form method="POST" action="{{ route('comments.like', $comment) }}" class="comment-like-form">
                    @csrf
                    <button type="submit" class="comment-like {{ $likedCommentIds->contains($comment->id) ? 'is-liked' : '' }}" aria-label="{{ $likedCommentIds->contains($comment->id) ? 'Quitar Me gusta' : 'Dar Me gusta' }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20.4 4.2 13A5.2 5.2 0 0 1 11.6 5.7l.4.5.4-.5A5.2 5.2 0 0 1 19.8 13L12 20.4Z"/></svg>
                        <span>{{ $comment->liked_by_count }}</span>
                    </button>
                </form>
            </article>
        @empty
            <div class="comments-empty"><strong>Aún no hay comentarios</strong><p>Sé la primera persona en compartir una experiencia sobre esta institución.</p></div>
        @endforelse
    </div>

    @if($institutionComments->count() > 1)
        <div class="comment-controls"><button type="button" data-comment-prev aria-label="Comentario anterior">‹</button><div data-comment-dots>@foreach($institutionComments as $comment)<button type="button" class="{{ $loop->first ? 'is-active' : '' }}" data-comment-dot="{{ $loop->index }}" aria-label="Ver comentario {{ $loop->iteration }}"></button>@endforeach</div><button type="button" data-comment-next aria-label="Comentario siguiente">›</button></div>
    @endif

    <details class="comment-compose" @if($errors->has('content') || session('status')) open @endif>
        <summary>Deja tu comentario aquí</summary>
        <div class="comment-compose-body">
            <p>Tu comentario será revisado antes de publicarse.</p>
            @if(session('status'))<div class="comment-status">{{ session('status') }}</div>@endif
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <input type="hidden" name="institution_id" value="{{ $institution->id }}">
                <label for="institution-comment">Tu comentario</label>
                <textarea id="institution-comment" name="content" minlength="10" maxlength="700" required placeholder="Comparte información útil y respetuosa sobre esta institución…">{{ old('content') }}</textarea>
                @error('content')<small class="comment-error">{{ $message }}</small>@enderror
                <div><small>Entre 10 y 700 caracteres</small><button type="submit">Enviar para revisión</button></div>
            </form>
        </div>
    </details>
</article>

<style>
.institution-comments-card{padding:24px;background:#fff;border:1px solid #dce5e1;border-radius:12px}.comments-heading{display:flex;align-items:center;justify-content:space-between}.comments-heading span{color:#15956e;font-size:8px;font-weight:800;letter-spacing:1.4px}.comments-heading h3{margin:4px 0 0;color:#102e28;font:800 21px Manrope}.comments-heading>small{color:#8a9692;font-size:9px}.institution-comment-track{margin-top:18px}.institution-comment{display:none;grid-template-columns:42px minmax(0,1fr) auto;align-items:start;gap:11px;min-height:112px}.institution-comment.is-active{display:grid;animation:comment-in .3s ease}.comment-avatar{width:42px;height:42px;border-radius:50%;overflow:hidden;background:#dff4ec}.comment-avatar img{width:100%;height:100%;object-fit:cover}.comment-avatar span{display:grid;height:100%;place-items:center;color:#087b5d;font:800 12px Manrope}.comment-copy strong{display:block;color:#151918;font-size:11px}.comment-copy p{margin:3px 0 6px;color:#4d5955;font-size:10px;line-height:1.5;overflow-wrap:anywhere}.comment-copy small{color:#99a29f;font-size:8px}.comment-like-form{margin:0}.comment-like{min-width:28px;padding:2px;border:0;background:transparent;color:#7e8985;cursor:pointer}.comment-like svg{display:block;width:19px;height:19px;margin:auto;fill:none;stroke:currentColor;stroke-width:1.7}.comment-like span{display:block;margin-top:2px;font-size:8px}.comment-like:hover,.comment-like.is-liked{color:#e43b56}.comment-like.is-liked svg{fill:currentColor}.comments-empty{min-height:95px;padding:17px;border-radius:9px;background:#f5f8f7}.comments-empty strong{font-size:11px}.comments-empty p{margin:4px 0 0;color:#73807b;font-size:9px}.comment-controls{display:flex;justify-content:center;align-items:center;gap:12px;margin-top:5px}.comment-controls>button{width:25px;height:25px;border:1px solid #dce5e1;border-radius:50%;background:#fff;color:#40514b;cursor:pointer}.comment-controls>div{display:flex;gap:5px}.comment-controls>div button{width:5px;height:5px;padding:0;border:0;border-radius:50%;background:#c5cecb}.comment-controls>div button.is-active{width:14px;border-radius:5px;background:#20b486}.comment-compose{margin-top:18px;border-top:1px solid #e3e9e6;padding-top:15px}.comment-compose summary{list-style:none;cursor:pointer;padding:11px 13px;border-radius:8px;background:#171817;color:#fff;font-size:10px;font-weight:800;text-align:center}.comment-compose summary::-webkit-details-marker{display:none}.comment-compose-body{padding-top:14px}.comment-compose-body>p{margin:0 0 10px;color:#77827e;font-size:9px}.comment-compose label{display:block;margin-bottom:5px;font-size:9px;font-weight:800}.comment-compose textarea{width:100%;min-height:95px;padding:10px;border:1px solid #d8e1dd;border-radius:8px;resize:vertical;font:10px/1.5 Inter}.comment-compose form>div{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:8px}.comment-compose form>div small{color:#89938f;font-size:8px}.comment-compose button[type=submit]{border:0;border-radius:7px;padding:9px 11px;background:#20b486;color:#fff;font-size:9px;font-weight:800;cursor:pointer}.comment-status{margin-bottom:10px;padding:10px;border-radius:7px;background:#dff4ec;color:#087b5d;font-size:9px}.comment-error{display:block;color:#b93636;font-size:8px}@keyframes comment-in{from{opacity:0;transform:translateX(6px)}to{opacity:1;transform:none}}
</style>
<script>
document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('[data-institution-comments]').forEach(root=>{const slides=[...root.querySelectorAll('[data-comment-slide]')],dots=[...root.querySelectorAll('[data-comment-dot]')],counter=root.querySelector('[data-comment-current]');if(slides.length<2)return;let index=0,timer;const show=next=>{index=(next+slides.length)%slides.length;slides.forEach((slide,i)=>slide.classList.toggle('is-active',i===index));dots.forEach((dot,i)=>dot.classList.toggle('is-active',i===index));if(counter)counter.textContent=index+1};const restart=()=>{clearInterval(timer);timer=setInterval(()=>show(index+1),6500)};root.querySelector('[data-comment-prev]')?.addEventListener('click',()=>{show(index-1);restart()});root.querySelector('[data-comment-next]')?.addEventListener('click',()=>{show(index+1);restart()});dots.forEach(dot=>dot.addEventListener('click',()=>{show(Number(dot.dataset.commentDot));restart()}));restart()})});
</script>
