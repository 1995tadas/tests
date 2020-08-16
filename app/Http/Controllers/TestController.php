<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Test;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TestController extends Controller
{
    private $test;

    public function __construct()
    {
        $this->test = new Test;
    }

    public function index()
    {
        $tests = $this->test->getLatestUserTests();
        return view('test.index', compact('tests'));
    }

    public function show($url)
    {
        if ($testAuthor = $this->test->getTestAuthor($url)) {
            $questions = $testAuthor->getUserQuestionsWithAnswers();
            return view('test.show', ['test' => $testAuthor, 'questions' => $questions]);
        } else if ($testGuest = $this->test->getTestGuest($url)) {
            return redirect(route('solutions.create', ['url' => $testGuest->url]));
        }
    }

    public function store(TestRequest $request)
    {
        $test = Test::create([
            'title' => ucfirst($request->title),
            'url' => Hashids::encode($this->test->getNextId('tests')),
            'user_id' => Auth::user()->id
        ]);
        return redirect(route('tests.show', ['url' => $test->url]));
    }

    public function edit($url)
    {
        $test = $this->test->getTestByUrl($url);
        return view('test.edit', compact('test'));
    }

    public function update(TestRequest $request, $url)
    {
        $test = $this->test->getTestByUrl($url);
        $update = $test->update($request->all());
        if ($update) {
            return redirect(route('tests.show', compact('url')));
        }
        return abort('404');
    }

    public function destroy($url)
    {
        $delete = Test::where('url', $url)->firstOrFail()->delete();
        if ($delete) {
            return response('success', 204);
        }
        return response('error', 404);
    }
}
