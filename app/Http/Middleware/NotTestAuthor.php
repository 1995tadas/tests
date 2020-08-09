<?php

namespace App\Http\Middleware;

use App\Test;
use Closure;
use Illuminate\Support\Facades\Auth;

class NotTestAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->route()->parameter('url');
        $test = Test::where('url', $url)->firstOrFail();
        if ($test->user_id !== Auth::user()->id) {
            return $next($request);
        } else {
            return redirect(route('tests.index'))->with('error', 'Autoriui neleidžiame spręsti šio testo!');
        }
    }
}
