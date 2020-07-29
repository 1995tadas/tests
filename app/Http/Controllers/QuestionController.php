<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($url)
    {
        $test = Test::where('url', $url)->where('user_id', Auth::user()->id)->firstOrFail();
        return view('question.create', ['test' => $test]);
    }

    public function store(Request $request)
    {
        $test = Test::findOrFail($request->test_id);
        $this->validation($request);
        $question = new Question();
        $question->content = $request->question;
        $question->test_id = $request->test_id;
        $question->save();
        $this->storeOrUpdateAnswer($request, 'create', $question->id);
        return redirect(route('question.create', ['url' => $test->url]))->with('message', 'Klausimas buvo sėkmingai išsaugotas!');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $test = Test::find($question->test_id);
        $answers = $question->answers->toArray();
        $values = [];
        $values['question'] = $question->content;
        foreach ($answers as $key => $answer) {
            $values['answers'][$key + 1] = $answer['content'];
            if ($answer['correct'] === 1) {
                $values['correct_answers'][$key + 1] = $answer['correct'];
            }
        }
        return view('question.edit', ['values' => $values, 'question' => $question, 'test' => $test]);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $test = Test::findOrFail($question->test_id);
        $this->validation($request);
        $question->content = $request->question;
        $question->save();
        $this->storeOrUpdateAnswer($request, 'update', $id);
        return redirect(route('test.show', ['url' => $test->url]))->with('message', 'Klausimas buvo sėkmingai redaguotas!');
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', 'Klausimas buvo sėkmingai ištrintas!');
        return response('success', 204);
    }

    public function storeOrUpdateAnswer($request, $storeOrUpdate, $question_id)
    {
        $max = Answer::where('question_id', $question_id)->max('number');
        foreach ($request->answers as $index => $value) {
            if ($storeOrUpdate === 'create' || $max < $index) {
                $answer = new Answer();
                $answer->question_id = $question_id;
            } else if ($storeOrUpdate === 'update') {
                $answer = Answer::where('number', $index)->where('question_id', $question_id)->first();
            }
            $answer->content = $value;
            $correct = false;
            if ($request->correct_answers) {
                foreach ($request->correct_answers as $correct_index => $correct_answer) {
                    if ($index === $correct_index) {
                        $correct = true;
                    }
                }
            }
            $answer->correct = $correct;
            if ($storeOrUpdate === 'create' || $max < $index) {
                $answer->number = $index;
            } else if ($storeOrUpdate === 'update') {
                $current_max = count($request->answers);
                if ($max > $current_max) {
                    Answer::where('question_id', $question_id)->where('number', '>', $current_max)->delete();
                }
            }
            $answer->save();
        }
    }

    private function validation($request)
    {
        return $request->validate([
            'question' => 'bail|required|max:255',
            'answers.*' => 'bail|required|max:255',
        ]);
    }
}
