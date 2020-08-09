<?php

namespace App\Http\Middleware;

use App\Test;
use Closure;
use Illuminate\Support\Facades\Auth;

class TestAuthor
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
        if (Test::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($url, $request) {$query->where('url', $url)->orWhere('id', $request->test_id);})
            ->first()) {
            return $next($request);
        } else {
            return redirect(route('tests.index'))->with('error','Tu nesi šio testo  autorius!');
        }
    }
}
