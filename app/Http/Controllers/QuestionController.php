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
            $pattern = '/^answer\d+/';
            $this->validation($request,$pattern);
            $question = new Question();
            $question->content = $request->question;
            $question->test_id = $request->test_id;
            $question->save();
            $question_id = $question->id;
            foreach ($request->all() as $id => $value) {
                if (preg_match($pattern, $id, $match)) {
                    $answer = new Answer();
                    $answer->question_id = $question_id;
                    $answer->content = $value;
                    foreach ($request->all() as $correct_id => $correct_value) {
                        if (preg_match('/^correct_answer/', $correct_id)) {
                            preg_match('/(\d+)$/', $id,$answer_id );
                            preg_match('/(\d+)$/',$correct_id,$correct_answer_id);
                            if($answer_id[0] === $correct_answer_id[0]){
                                $answer->correct = true;
                                break;
                            }
                        }
                    }
                    $answer->number = $answer_id[0];
                    $answer->save();
                }
            }
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
                $values['answer'.($key + 1)] = $answer['content'];
                if($answer['correct'] === 1){
                    $values['correct_answer'.($key + 1)] = $answer['correct'];
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
            $pattern = '/^answer\d+/';
            $this->validation($request,$pattern);
            $question->content = $request->question;
            $question->save();
            $this->saveAnswer($request, $pattern, $id);
            return redirect(route('test.show', ['url' => $test->url]))->with('message', 'Klausimas buvo sėkmingai redaguotas!');
        } else {
            return redirect(route('login'));
        }
    }
    public function destroy($id){
        Question::find($id)->delete();
        return redirect()->back()->with('message','Klausimas buvo sėkmingai ištrintas!');
    }

    public function validation($request, $pattern){
        $questionValidation = [
            'question' => 'required|max:255',
        ];
        $answerValidation = array_fill_keys(preg_grep($pattern, array_keys($request->all())), 'required');
        $request->validate(array_merge($questionValidation, $answerValidation));
    }
    public function saveAnswer($request, $pattern, $question_id){
        foreach ($request->all() as $index => $value) {
            if (preg_match($pattern, $index)) {
                preg_match('/(\d+)$/', $index,$number );
                $answer = Answer::where('number', $number[0])->first();
                $correct = 0;
                    $answer->content = $value;
                    foreach ($request->all() as $correct_id => $correct_value) {
                        if (preg_match('/^correct_answer/', $correct_id)) {
                            preg_match('/(\d+)$/', $index,$answer_id );
                            preg_match('/(\d+)$/',$correct_id,$correct_answer_id);
                            if($answer_id[0] === $correct_answer_id[0]){
                                $correct = true;
                                break;
                            }
                        }
                    }
                $answer->correct = $correct;
                $answer->save();
            }
        }
    }
}
