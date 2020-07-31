<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public function solutionAnswers()
    {
        return $this->hasMany(SolutionAnswer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class)->with('user');
    }
}
