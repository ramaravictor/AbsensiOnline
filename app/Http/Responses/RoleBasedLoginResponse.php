<?php

namespace App\Http\Responses; // Pastikan namespace Anda sesuai

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk logging jika diperlukan
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
// Anda mungkin perlu meng-import User model jika IDE masih bingung,
// meskipun PHPDoc seharusnya sudah cukup.
// use App\Models\User;

class RoleBasedLoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        /** @var \App\Models\User|null $user */ // <-- PASTIKAN BARIS INI ADA DAN BENAR
        $user = Auth::user();

        // Pengecekan apakah $user tidak null (praktik baik)
        if ($user) {
            // Anda bisa menambahkan logging di sini untuk memastikan nilai $user->role dan hasil isAdmin()
            // Log::info('RoleBasedLoginResponse: User Role = ' . $user->role . ', isAdmin = ' . ($user->isAdmin() ? 'true' : 'false'));

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isEmployee()) {
                return redirect()->intended(route('user.home'));
            }
        } else {
            // Seharusnya tidak terjadi jika ini dipanggil setelah login sukses
            // Log::error('RoleBasedLoginResponse: Auth::user() is null after successful login attempt.');
        }

        // Fallback jika $user null atau tidak ada peran yang cocok (misalnya peran lain yang belum ditangani)
        return redirect()->intended(config('fortify.home'));
    }
}
