<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function create($url) {
        $test = Test::where('url', $url)->where('user_id', Auth::user()->id)->firstOrFail();
        if ($test) {
            return view('question.create',['test' => $test]);
        } else {
            return redirect(route('login'));
        }
    }
    public function store(Request $request)
    {
        $test = Test::findOrFail($request->test_id);
        if (Auth::check() && $test->user_id === Auth::user()->id) {
            $request->validate([
                'question'=>'required|max:255',
                'answers.*' => 'required|max:255',
            ]);
            $question = new Question();
            $question->content = $request->question;
            $question->test_id = $request->test_id;
            $question->save();
            $this->saveAnswer($request, 'create', $question->id);
            return redirect(route('test.show', ['url' => $test->url]))->with('message', 'Klausimas buvo sėkmingai išsaugotas!');
        } else {
            return redirect(route('login'));
        }
    }
    public function edit($id){
        $question = Question::find($id);
        $answers = $question->answers->toArray();
        if ($question && $answers) {
            $values = [];
            $values['question'] = $question->content;
            foreach ($answers as $key => $answer){
                $values['answers'][$key + 1] = $answer['content'];
                if($answer['correct'] === 1){
                    $values['correct_answers'][$key + 1] = $answer['correct'];
                }
            }
            return view('question.edit',['values' => $values,'question' => $question]);
        } else {
            return redirect(route('login'));
        }
    }
    public function update(Request $request, $id){
        $question = Question::find($id);
        $test = Test::findOrFail($question->test_id);
        if(Auth::check() && $test->user_id === Auth::user()->id){
            $request->validate([
                'question'=>'required|max:255',
                'answers.*' => 'required|max:255',
            ]);
            $question->content = $request->question;
            $question->save();
            $this->saveAnswer($request, 'update', $id);
            return redirect(route('test.show', ['url' => $test->url]))->with('message', 'Klausimas buvo sėkmingai redaguotas!');
        } else {
            return redirect(route('login'));
        }
    }
    public function destroy($id){
        Question::find($id)->delete();
        return redirect()->back()->with('message','Klausimas buvo sėkmingai ištrintas!');
    }

    public function saveAnswer($request, $createOrUpdate, $question_id){
        $max = Answer::where('question_id', $question_id)->max('number');
        foreach ($request->answers as $index => $value){
           if($createOrUpdate === 'create' || $max < $index){
               $answer = new Answer();
               $answer->question_id = $question_id;
           } else if($createOrUpdate === 'update') {
               $answer = Answer::where('number', $index)->first();
           }
           $answer->content = $value;
           $correct = false;
           if($request->correct_answers){
               foreach ($request->correct_answers as $correct_index => $correct_answer){
                   if($index === $correct_index){
                       $correct = true;
                   }
               }
           }
           $answer->correct = $correct;
           if($createOrUpdate === 'create' || $max < $index){
               $answer->number = $index;
           } else if($createOrUpdate === 'update'){
               $current_max = count($request->answers);
               if($max > $current_max){
                   Answer::where('question_id', $question_id)->where('number','>', $current_max)->delete();
               }
           }
           $answer->save();
       }
    }
}
