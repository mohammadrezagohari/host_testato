<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
//        dd(Auth::user()->hasRole(Roles::SuperLevel));
        if (!Auth::user()->hasRole(Roles::SuperLevel)) {
            return abort(Response::HTTP_CONFLICT,'YOU ACCESS THIS PAGE , YOU HAVE NOT ACCESS TO ADMIN ROLES');
//            return abort(Response::HTTP_FORBIDDEN,'YOU ACCESS THIS PAGE , YOU HAVE NOT ACCESS TO ADMIN ROLES');
        }
        return $next($request);
    }
}
