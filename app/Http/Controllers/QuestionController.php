<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\QuestionRequest;
use App\Question;
use App\Services\AnswerService;
use App\Setting;
use App\Test;

class QuestionController extends Controller
{
    public function create($url)
    {
        $test = $this->testModel()->getTestAuthor($url);
        $setting = $this->settingModel()->getCurrentUser();
        if (!$test || !$setting) {
            abort('404');
        }
        return view('question.create', compact('test', 'setting'));
    }

    public function store(QuestionRequest $request)
    {
        $test = $this->testModel()->findTest($request->test_id);
        $question = $this->questionModel()::create([
            'content' => $request->content,
            'test_id' => $request->test_id
        ]);
        if ($question) {
            $answers = AnswerService::formatAnswersForStorage($request, $question->id);
        }
        if ($answers || isset($answers)) {
            $this->answerModel()::insert($answers);
            return redirect(route('questions.create', ['url' => $test->url]));
        }
        return abort('404');
    }

    public function edit($id)
    {
        $question = $this->questionModel()->findQuestion($id);
        $test = $this->testModel()->findTest($question->test_id);
        $preparedValues = AnswerService::prepareAnswersForEdit($question->answers, $question);
        return view('question.edit', compact('preparedValues', 'test', 'question'));
    }

    public function update(QuestionRequest $request, $id)
    {
        $question = $this->questionModel()->findQuestion($id);
        $question->update(['content' => $request->content]);

        if ($question) {
            $answers = AnswerService::formatAnswersForStorage($request, $id);
        }
        if ($answers || isset($answers)) {
            $this->answerModel()->deleteAnswersByQuestionId($question->id, count($answers));
            foreach ($answers as $answer) {
                Answer::where('question_id', $answer['question_id'])->updateOrCreate(
                    ['question_id' => $answer['question_id'], 'number' => $answer['number']],
                    ['content' => $answer['content'], 'correct' => $answer['correct']]
                );
            }
            $test = $this->testModel()->findTest($question->test_id);
            return redirect(route('tests.show', ['url' => $test->url]));
        }

        return redirect(route('tests.index'));
    }

    public function destroy($id)
    {
        $delete = $this->questionModel()->findQuestion($id)->delete();
        if ($delete) {
            return response('success', 204);
        }
    }

    private function testModel()
    {
        return new Test;
    }

    private function settingModel()
    {
        return new Setting;
    }

    private function questionModel()
    {
        return new Question;
    }

    private function answerModel()
    {
        return new Answer;
    }
}
