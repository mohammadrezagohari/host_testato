<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return abort(HTTPResponse::HTTP_UNAUTHORIZED,'لطفا احراز هویت کنید');//route('login');
        }
    }

//    public function handle($request, Closure $next, ...$guards)
//    {
//        if ($token = $request->header('Authorization')) {
//            try {
//                $this->authenticate($request, $guards);
//
//            } catch (\Exception $e) {
//                return response()->json(['error' => 'Invalid token'], 401);
//            }
//        }
//        return $next($request);
//    }
}
