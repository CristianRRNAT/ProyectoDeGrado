<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        abort_unless(config('services.google.client_id') && config('services.google.client_secret'), 503, 'El acceso con Google todavía no fue configurado.');

        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user && ! $user->is_active) {
                return redirect()->route('login')->withErrors(['email' => 'Esta cuenta se encuentra desactivada.']);
            }

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Usuario de OrientaBo',
                    'email' => $googleUser->getEmail(),
                    'password' => Str::random(40),
                    'google_id' => $googleUser->getId(),
                    'avatar_url' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar_url' => $googleUser->getAvatar() ?: $user->avatar_url,
                    'email_verified_at' => $user->email_verified_at ?: now(),
                ]);
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            return redirect()->route('home')->with('status', 'Ingresaste correctamente con Google.');
        } catch (Throwable $exception) {
            Log::warning('Error al iniciar sesión con Google', ['message' => $exception->getMessage()]);
            return redirect()->route('login')->withErrors(['email' => 'No pudimos completar el acceso con Google. Inténtalo nuevamente.']);
        }
    }
}
