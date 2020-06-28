<?php

namespace App\Http\Middleware;

use App\Solution;
use App\Test;
use Closure;
use Illuminate\Support\Facades\Auth;

class SolutionAuth
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
        $id = $request->route()->parameter('id');
        $solution = Solution::findOrFail($id);
        $user_id = Auth::user()->id;
        if (Test::find($solution->test_id)->user_id === $user_id || $solution->user_id === $user_id) {
            return $next($request);
        } else {
            return redirect(route('test.index'))->with('error', 'Tau neleidžiama matyti šio sprendimo!');
        }
    }
}
