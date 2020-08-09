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
        $question = Question::create([
            'content' => $request->content,
            'test_id' => $request->test_id
        ]);
        if ($question) {
            $answers = $this->formatAnswersForStorage($request, $question->id);
        }
        if (isset($answers)) {
            Answer::insert($answers);
            return redirect(route('questions.create', ['url' => $test->url]))
                ->with('message', __('messages.question') . ' ' . __('messages.saved') . '!');
        }
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $test = Test::find($question->test_id);
        $answers = $question->answers->toArray();
        $values = [];
        $values['content'] = $question->content;
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
        $request->validate($this->rules());
        $question->update(['content' => $request->content]);

        if ($question) {
            $answers = $this->formatAnswersForStorage($request, $id);;
        }
        if (isset($answers)) {
            Answer::where('question_id', $question->id)->where('number', '>', count($answers))->delete();
            $numberOfAnswers = Answer::where('question_id', $question->id)->max('number');
            foreach ($answers as $answer) {
                if ($answer['number'] <= $numberOfAnswers) {
                    Answer::where('number', $answer['number'])
                        ->where('question_id', $answer['question_id'])
                        ->update([
                            'content' => $answer['content'],
                            'correct' => $answer['correct']
                        ]);
                } else {
                    Answer::create([
                        'question_id' => $answer['question_id'],
                        'number' => $answer['number'],
                        'content' => $answer['content'],
                        'correct' => $answer['correct']
                    ]);
                }
            }
            $test = Test::findOrFail($question->test_id);
            return redirect(route('tests.show', ['url' => $test->url]))->with('message', __('messages.question') . ' ' . __('messages.edited') . '!');
        }
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', __('messages.question') . ' ' . __('messages.deleted') . '!');
        return response('success', 204);
    }

    private function formatAnswersForStorage($request, $question_id)
    {
        $answers = [];
        foreach ($request->answers as $index => $value) {
            $answer = [];
            $answer['question_id'] = $question_id;
            $answer['content'] = $value;
            $answer['correct'] = false;
            if ($request->correct_answers) {
                foreach ($request->correct_answers as $correct_index => $correct_answer) {
                    if ($index === $correct_index) {
                        $answer['correct'] = true;
                        break;
                    }
                }
            }
            $answer['number'] = $index;
            $answers[] = $answer;
        }
        return $answers;
    }

    private function rules()
    {
        return [
            'content' => 'bail|required|max:255',
            'answers.*' => 'bail|required|max:255',
        ];
    }
}
