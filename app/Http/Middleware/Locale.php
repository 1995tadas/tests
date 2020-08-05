<?php

namespace App\Http\Middleware;

use App\Setting;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $languageInSession = Session::has('language');
        $user = Auth::check();
        if ($languageInSession) {
            $language = Session::get('language');
        } else if ($user) {
            $language = Setting::where('user_id', Auth::user()->id)->firstOrFail()->language;
        }
        if (isset($language)) {
            if (!in_array($language, ['en', 'lt'])) {
                abort(400);
            }
            if ($user && !$languageInSession) {
                Session::put('language', $language);
            }
            App::setLocale($language);
        }

        return $next($request);
    }
}
