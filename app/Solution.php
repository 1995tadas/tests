<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public function solutionAnswers()
    {
        return $this->hasMany(SolutionAnswer::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsToMany(User::class, Test::class, 'id', 'user_id');
    }
}
