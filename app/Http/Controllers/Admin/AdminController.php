<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Comment;
use App\Models\Institution;
use App\Models\Opportunity;
use App\Models\OpportunitySubmission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', ['stats'=>[
            'Usuarios'=>User::count(),'Instituciones'=>Institution::where('is_active',true)->count(),
            'Carreras'=>Career::where('is_active',true)->count(),'Oportunidades'=>Opportunity::where('is_active',true)->count(),
            'Solicitudes pendientes'=>OpportunitySubmission::where('status','pending')->count(),
            'Comentarios pendientes'=>Comment::where('status','pending')->count(),
        ], 'submissions'=>OpportunitySubmission::latest()->limit(5)->get(), 'comments'=>Comment::with('user')->latest()->limit(5)->get()]);
    }

    public function users(): View { return view('admin.users', ['users'=>User::latest()->paginate(20)]); }

    public function toggleUser(User $user, Request $request): RedirectResponse
    {
        abort_if($user->is($request->user()), 422, 'No puedes desactivar tu propia cuenta.');
        $user->update(['is_active'=>!$user->is_active]);
        return back()->with('status','Estado del usuario actualizado.');
    }

    public function submissions(): View { return view('admin.submissions', ['submissions'=>OpportunitySubmission::latest()->paginate(20)]); }
    public function reviewSubmission(OpportunitySubmission $submission, Request $request): RedirectResponse
    {
        $data=$request->validate(['status'=>['required','in:approved,rejected']]);
        $submission->update($data);
        return back()->with('status','Solicitud revisada correctamente.');
    }

    public function comments(): View { return view('admin.comments', ['comments'=>Comment::with(['user','institution'])->latest()->paginate(20)]); }
    public function reviewComment(Comment $comment, Request $request): RedirectResponse
    {
        $data=$request->validate(['status'=>['required','in:approved,rejected']]);
        $comment->update($data+['reviewed_by'=>$request->user()->id,'reviewed_at'=>now()]);
        return back()->with('status','Comentario moderado correctamente.');
    }
}
