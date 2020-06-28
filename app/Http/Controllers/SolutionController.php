<?php

namespace App\Http\Controllers;

use App\Solution;
use App\SolutionAnswer;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        $solution = Solution::where('test_id', $test->id)->where('user_id', Auth::user()->id)->exists();
        return view('solution.create', ['test' => $solution ? null : $test]);
    }

    public function store(Request $request, $url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        $solution = new Solution();
        $solution->user_id = Auth::user()->id;
        $solution->test_id = $test->id;
        $solution->save();
        if ($solution) {
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^(\d+)-answer/', $key, $matches)) {
                    foreach ($value as $answer_number => $answer_value) {
                        $solution_answer = new SolutionAnswer();
                        $solution_answer->solution_id = $solution->id;
                        $solution_answer->question_id = $matches[1];
                        $solution_answer->answer_number = $answer_number;
                        $solution_answer->save();
                    }
                }
            }
            return redirect(route('solution.show', ['id' => $solution->id]));
        }
    }

    public function index($id)
    {
        $solutions = Solution::where('test_id', $id)->get();
        return view('solution.index', ['solutions' => $solutions]);
    }

    public function show($id)
    {
        $solution = Solution::findOrFail($id);
        $test = Test::findOrFail($solution->test_id);
        return view('solution.show', ['test' => $test, 'solution' => $solution]);
    }
}
