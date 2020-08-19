<?php
/**
 * Created by PhpStorm.
 * User: Parallax PC-1
 * Date: 12/20/2017
 * Time: 3:40 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EpAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('ep_admin')->check()) {
            return $next($request);
        } else {
            return redirect('ep/login');
        }
    }
}