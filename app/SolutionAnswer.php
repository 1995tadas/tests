<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolutionAnswer extends Model
{
    protected  $fillable = ['solution_id', 'question_id', 'answer_number'];
}
