<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\VocationalTestController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleAuthController;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'communityComments' => Comment::with('user')
            ->where('status', 'approved')
            ->whereNull('institution_id')
            ->latest('reviewed_at')
            ->limit(4)
            ->get(),
    ]);
})->name('home');

Route::get('/instituciones', [InstitutionController::class, 'index'])->name('institutions.index');
Route::redirect('/instituciones/itsa', '/instituciones/instituto-tecnologico-sacaba', 301)->name('institutions.sacaba');
Route::get('/instituciones/{institution:slug}', [InstitutionController::class, 'show'])
    ->middleware('auth')->name('institutions.show');

Route::get('/test-vocacional', [VocationalTestController::class, 'basic'])
    ->name('test.basic');

Route::middleware('auth')->group(function () {
    Route::get('/test-vocacional/completo', [VocationalTestController::class, 'complete'])->name('test.complete');
    Route::post('/test-vocacional/completo', [VocationalTestController::class, 'storeComplete'])->name('test.complete.store');
    Route::get('/mis-resultados/{result}', [VocationalTestController::class, 'result'])->name('test.results.show');
    Route::get('/mis-resultados/{result}/pdf', [VocationalTestController::class, 'downloadPdf'])->name('test.results.pdf');
    Route::get('/oportunidades', [OpportunityController::class, 'index'])->name('opportunities.index');
    Route::post('/oportunidades/solicitudes', [OpportunityController::class, 'storeSubmission'])
        ->middleware('throttle:5,10')->name('opportunities.submissions.store');
    Route::get('/compartir-experiencia', [CommentController::class,'create'])->name('comments.create');
    Route::post('/compartir-experiencia', [CommentController::class,'store'])->middleware('throttle:3,10')->name('comments.store');
    Route::post('/comentarios/{comment}/me-gusta', [CommentController::class,'toggleLike'])->middleware('throttle:20,1')->name('comments.like');
});

Route::get('/carreras', [CareerController::class, 'index'])->name('careers.index');
Route::get('/carreras/{career:slug}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'chat'])
    ->middleware('throttle:10,1')
    ->name('chatbot.chat');

Route::middleware('guest')->group(function () {
    Route::get('/autenticacion/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/autenticacion/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
    Route::get('/iniciar-sesion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/iniciar-sesion', [AuthController::class, 'login'])->name('login.store');
    Route::get('/crear-cuenta', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/crear-cuenta', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/cerrar-sesion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class,'users'])->name('users');
    Route::patch('/usuarios/{user}/estado', [AdminController::class,'toggleUser'])->name('users.toggle');
    Route::get('/solicitudes', [AdminController::class,'submissions'])->name('submissions');
    Route::patch('/solicitudes/{submission}', [AdminController::class,'reviewSubmission'])->name('submissions.review');
    Route::get('/comentarios', [AdminController::class,'comments'])->name('comments');
    Route::patch('/comentarios/{comment}', [AdminController::class,'reviewComment'])->name('comments.review');
    Route::get('/{resource}', [ContentController::class,'index'])->name('content.index');
    Route::get('/{resource}/crear', [ContentController::class,'create'])->name('content.create');
    Route::post('/{resource}', [ContentController::class,'store'])->name('content.store');
    Route::get('/{resource}/{id}/editar', [ContentController::class,'edit'])->name('content.edit');
    Route::put('/{resource}/{id}', [ContentController::class,'update'])->name('content.update');
    Route::delete('/{resource}/{id}', [ContentController::class,'destroy'])->name('content.destroy');
});
