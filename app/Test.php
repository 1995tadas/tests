<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function questionById($id)
    {
        return Question::find($id);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
