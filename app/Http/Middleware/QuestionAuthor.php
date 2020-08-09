<?php

namespace App\Http\Middleware;

use App\Question;
use App\Test;
use Closure;
use Illuminate\Support\Facades\Auth;

class QuestionAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{       $id = $request->route()->parameter('id');
        if(Test::where('user_id', Auth::user()->id)->find(Question::find($id)->test_id)){
            return $next($request);
        } else {
            return redirect(route('tests.index'))->with('error','Tu nesi šio klausimo autorius!');
        }
    }
}
