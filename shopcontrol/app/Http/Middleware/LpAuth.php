<?php
/**
 * Created by PhpStorm.
 * User: Parallax PC-1
 * Date: 12/13/2017
 * Time: 10:44 AM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class LpAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (Auth::guard('lp_admin')->check()) {
//            dd(Auth::guard('lp_admin')->user());
            return $next($request);
        } else {
            return redirect('lp/login');
        }
    }
}