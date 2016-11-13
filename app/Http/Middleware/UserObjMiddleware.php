<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\User;
use Closure;

class UserObjMiddleware
{
    /**
     * Handle an incoming request.
     *  Check for the user that's currently authenticated
     * passes his ID through the request, to use in an user_id based functions
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //get user
        $user = Auth::user();
        if (!$user) {
            return response('No authenticated user', 401)
                ->header('Content-Type', 'application/json');
        } else {
            $request->user = $user;
        }
        return $next($request);
    }
}
