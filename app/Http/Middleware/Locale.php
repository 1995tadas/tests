<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('language')) {
            $language = Session::get('language');
            if (!in_array($language, ['en', 'lt'])) {
                abort(400);
            }
            App::setLocale($language);
        }
        return $next($request);
    }
}
