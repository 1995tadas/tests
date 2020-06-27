<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tests = Test::where('user_id', Auth::user()->id)->paginate(10);
        return view('test.index', ['tests' => $tests]);
    }

    public function show($url)
    {
        $test_guest = Test::where('url', $url)->firstOrFail();
        $test_author = Test::where('url', $url)->where('user_id', Auth::user()->id)->first();
        if ($test_author) {
            return view('test.show', ['test' => $test_author]);
        } else if ($test_guest) {
            return redirect(route('solution.create', ['url' => $test_guest->url]));
        }
    }

    public function create()
    {
        return view('test.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $test_id = Test::latest('id')->first();
        !$test_id ? $test_id = 1 : $test_id = ($test_id->id) + 1;
        $test = new Test();
        $test->title = ucfirst($request->title);
        $test->url = Hashids::encode($test_id);
        $test->user_id = Auth::user()->id;
        $test->save();
        return redirect(route('test.show', ['url' => $test->url]));
    }

    public function edit($url)
    {
        $test = Test::where('url', $url)->first();
        return view('test.edit', ['test' => $test]);
    }

    public function update(Request $request, $url)
    {
        $this->validation($request);
        $test = Test::where('url', $url)->firstOrFail();
        $test->title = ucfirst($request->title);
        $test->save();
        return redirect(route('test.show', ['url' => $test->url]));
    }

    public function destroy($url)
    {
        Test::where('url', $url)->delete();
        return redirect(route('test.index'))->with('message', 'Testas sėkmingai ištrintas!');
    }

    private function validation($request)
    {
        return $request->validate([
            'title' => 'bail|required|max:60'
        ]);
    }
}
