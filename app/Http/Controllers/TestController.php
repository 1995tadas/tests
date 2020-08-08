<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::where('user_id', Auth::user()->id)->paginate(10);
        return view('test.index', compact('tests'));
    }

    public function show($url)
    {
        $test = Test::where('url', $url);
        if ($test_author = $test->where('user_id', Auth::user()->id)->first()) {
            return view('test.show', ['test' => $test_author]);
        } else if ($test_guest = $test->firstOrFail()) {
            return redirect(route('solution.create', ['url' => $test_guest->url]));
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $test_id = Test::latest('id')->first();
        !$test_id ? $test_id = 1 : $test_id = ($test_id->id) + 1;
        $test = Test::create([
            'title' => ucfirst($request->title),
            'url' => Hashids::encode($test_id),
            'user_id' => Auth::user()->id
        ]);
        return redirect(route('test.show', ['url' => $test->url]));
    }

    public function edit($url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        return view('test.edit', compact('test'));
    }

    public function update(Request $request, $url)
    {
        $request->validate($this->rules());
        $test = Test::where('url', $url)->firstOrFail();
        $test->update($request->all());
        return redirect(route('test.show', ['url' => $test->url]));
    }

    public function destroy($url)
    {
        Test::where('url', $url)->delete();
        session()->flash('message', __('messages.test') . ' ' . __('messages.deleted') . '!');
        return response('success', 204);
    }

    private function rules()
    {
        return [
            'title' => 'bail|required|max:60'
        ];
    }
}
