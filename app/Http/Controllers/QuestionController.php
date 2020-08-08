<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Setting;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function create($url)
    {
        $user = Auth::user();
        $test = Test::where('url', $url)->where('user_id', $user->id)->firstOrFail();
        $setting = Setting::where('user_id', $user->id)->firstOrFail('default_questions');
        return view('question.create', compact('test', 'setting'));
    }

    public function store(Request $request)
    {
        $test = Test::findOrFail($request->test_id);
        $request->validate($this->rules());
        $question = new Question();
        $question->content = $request->question;
        $question->test_id = $request->test_id;
        $question->save();
        $this->storeOrUpdateAnswer($request, 'store', $question->id);
        return redirect(route('question.create', ['url' => $test->url]))->with('message', __('messages.question') . ' ' . __('messages.saved') . '!');
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
        return redirect(route('test.show', ['url' => $test->url]))->with('message', __('messages.question') . ' ' . __('messages.edited') . '!');
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', __('messages.question') . ' ' . __('messages.deleted') . '!');
        return response('success', 204);
    }

    public function storeOrUpdateAnswer($request, $storeOrUpdate, $question_id)
    {
        $max = Answer::where('question_id', $question_id)->max('number');
        foreach ($request->answers as $index => $value) {
            if ($storeOrUpdate === 'store' || $max < $index) {
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
            if ($storeOrUpdate === 'store' || $max < $index) {
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

    private function rules()
    {
        return [
            'question' => 'bail|required|max:255',
            'answers.*' => 'bail|required|max:255',
        ];
    }
}
