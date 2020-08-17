<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['content', 'test_id'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function findQuestion($id)
    {
        return $this->findOrFail($id);
    }
}
