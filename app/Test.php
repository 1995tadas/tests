<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Test extends Model
{

    protected $fillable = ['title', 'url', 'user_id'];

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

    public function getLatestUserTests()
    {
        return $this->where('user_id', Auth::user()->id)->latest()->paginate(10);
    }

    public function getTestAuthor($url)
    {
        return $this->where('url', $url)->where('user_id', Auth::user()->id)->first();
    }

    public function getTestGuest($url)
    {
        return $this->where('url', $url)->firstOrFail();
    }

    public function getTestWithQuestions($url)
    {
        return $this->where('url', $url)->with('questions')->firstOrFail();
    }

    public function getUserQuestionsWithAnswers()
    {
        return $this->questions()->with('answers')->paginate(5);
    }

    public function getNextId($tableName)
    {
        $statement = DB::select("show table status like '" . $tableName . "'");
        return $statement ? $statement[0]->Auto_increment : abort(404);
    }

    public function getTestByUrl($url)
    {
        return $this->where('url', $url)->firstOrFail();
    }

    public function findTest($id)
    {
        return $this->findOrFail($id);
    }
}
