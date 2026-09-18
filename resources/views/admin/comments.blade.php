@extends('admin.layout')
@section('title','Comentarios')
@section('heading','Moderación de comentarios')
@section('content')
<p class="page-note">Solo los comentarios aprobados podrán mostrarse públicamente.</p>
<section class="request-grid">
@forelse($comments as $item)
    <article class="request-card comment-card">
        <div class="request-top"><span>{{ $item->user->name }}@if($item->institution) · {{ $item->institution->name }}@endif</span><em class="status {{ $item->status }}">{{ $item->status }}</em></div>
        <blockquote>“{{ $item->content }}”</blockquote>
        <small>{{ $item->created_at->format('d/m/Y H:i') }}</small>
        @if($item->status==='pending')
            <div class="review-actions">
                <form method="POST" action="{{ route('admin.comments.review',$item) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="approve">Publicar</button></form>
                <form method="POST" action="{{ route('admin.comments.review',$item) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="reject">Rechazar</button></form>
            </div>
        @endif
    </article>
@empty
    <p class="empty">No existen comentarios pendientes.</p>
@endforelse
</section>
<div class="admin-pagination">{{ $comments->links() }}</div>
@endsection
