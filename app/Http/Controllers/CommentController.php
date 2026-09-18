<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function create(): View
    {
        return view('comments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'min:10', 'max:700'],
            'institution_id' => ['nullable', 'integer', 'exists:institutions,id'],
        ]);

        Comment::create($data + ['user_id' => $request->user()->id, 'status' => 'pending']);

        return back()->with('status', 'Gracias. Tu comentario será revisado por el administrador y, si cumple las normas, se publicará en los próximos días.');
    }

    public function toggleLike(Comment $comment, Request $request): RedirectResponse
    {
        abort_unless($comment->status === 'approved', 404);
        $comment->likedBy()->toggle($request->user()->id);

        return back();
    }
}
