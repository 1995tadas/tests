<?php


namespace App\Services;


class AnswerService
{
    public static function formatAnswersForStorage($request, $question_id)
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

    public static function prepareAnswersForEdit($answers, $question)
    {
        $values = [];
        $values['content'] = $question->content;
        foreach ($answers as $key => $answer) {
            $values['answers'][$key + 1] = $answer['content'];
            if ($answer['correct'] === 1) {
                $values['correct_answers'][$key + 1] = $answer['correct'];
            }
        }
        return $values;
    }
}
