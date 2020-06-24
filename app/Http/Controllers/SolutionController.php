<?php

namespace App\Http\Controllers;

use App\Question;
use App\Solution;
use App\SolutionAnswer;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    public function create($url){
        $test = Test::where('url', $url)->firstOrFail();
        $solution = Solution::where('test_id', $test->id)->where('user_id', Auth::user()->id)->exists();
        return view('solution.create', ['test' => $solution ? null : $test]);
    }
    public function show($id){
        $solution = Solution::findOrFail($id);
        $test = Test::findOrFail($solution->test_id);
        return view('solution.show', ['test' => $test, 'solution' => $solution]);
    }
    public function index($id){
        $solutions = Solution::where('test_id', $id)->get();
        return view('solution.index', ['solutions' => $solutions]);

    }
    public function store(Request $request, $url){
        $test = Test::where('url',$url)->firstOrFail();
        $solution = new Solution();
        $solution->user_id = Auth::user()->id;
        $solution->test_id = $test->id;
        $solution->save();
        if($solution){
            foreach ($request->all() as $key => $value){
                if(preg_match('/^(\d+)-answer/', $key, $matches)) {
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

//    public function results($test_id){
//        $questions = Question::where('test_id', $test_id)->get();
//        $solutions = Solution::where('test_id', $test_id)->get();
//        $array = [];
//        foreach ($questions as $question){
//            foreach ($solutions as $solution){
//                $correct = 0;
//                $incorrect = 0;
//                foreach ($solution->solutionAnswers as $solutionAnswer){
//                    if($question->id === $solutionAnswer->question_id){
//                        foreach($question->answers as $answer){
//                            if($answer->number === $solutionAnswer->answer_number){
//                               if($answer->correct){
//                                   $correct++;
//                               } else {
//                                   $incorrect++;
//                               }
//                               break;
//                            }
//                            if($answer->correct){
//                                $incorrect++;
//                            }
//                        }
//                    }
//                }
//                $array[$solution->id] = ['correct' => $correct, 'incorrect' => $incorrect];
//            }
//        }
//        $solutions = Solution::whereIn('id', array_keys($array))->get();
//        return view('solution.results', ['solutions' => $solutions, 'results'=> $array]);
//    }
}
