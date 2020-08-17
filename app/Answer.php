<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id', 'number', 'content', 'correct'];

    public function deleteAnswersByQuestionId($questionId, $number)
    {
        Answer::where('question_id', $questionId)->where('number', '>', $number)->delete();
    }
}
