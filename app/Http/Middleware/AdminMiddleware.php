<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_ADMIN) {

            return $next($request);
        }
        abort(403, 'Anda tidak memiliki hak akses Admin.');
    }
}
