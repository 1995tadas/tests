<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public function solutionAnswers(){
        return $this->hasMany(SolutionAnswer::class);
    }
}
