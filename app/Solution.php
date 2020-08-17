<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = ['user_id', 'test_id', 'show'];

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

    public function countUserSolutionsByTestId($testId, $userId)
    {
        return $this->where('test_id', $testId)->where('user_id', $userId)->count();
    }

    public function whereUserSolutionShowExistsByTestId($testId, $userId)
    {
        return $this->where('test_id', $testId)->where('user_id', $userId)->where('show', true)->exists();
    }

    public function findSolution($id)
    {
        return $this->findOrFail($id);
    }

    public function findSolutionWhereShowFalse($id)
    {
        return $this->where('show', false)->findOrFail($id);
    }
}
