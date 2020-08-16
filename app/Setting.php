<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    protected $fillable = ['user_id', 'language', 'test_attempts', 'default_questions'];

    public function getCurrentUser()
    {
        return $this->where('user_id', Auth::user()->id)->first();
    }

}
