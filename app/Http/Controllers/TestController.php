<?php

namespace App\Http\Controllers;


use App\Answer;
use App\Question;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TestController extends Controller
{
    public function index(){

        $tests = Test::where('user_id', Auth::user()->id)->get();
        return view('test.index', ['tests' => $tests]);
    }
    public function show($url){
        $test = Test::where('url', $url)->first();
        return view('test.show',['test' => $test]);
    }
    public function create(){
        if (Auth::check()) {
            return view('test.create');
        } else {
            return redirect(route('login'));
        }
    }
    public function store(Request $request){
        $user = Auth::user();
        if ($user) {
            $request->validate([
                'title'=> 'required'
            ]);
            $test_id = Test::latest('id')->first();
            !$test_id ? $test_id = 1 : $test_id = ($test_id->id) + 1;
            $test = new Test();
            $test->title = ucfirst($request->title);
            $test->url = Hashids::encode($test_id);
            $test->user_id = $user->id;
            $test->save();
            return redirect(route('test.show',['url' => $test->url]));
        } else {
            return redirect(route('login'));
        }
    }
    public function destroy($id){
        Test::find($id)->delete();
        return redirect(route('test.index'))->with('message','Testas sėkmingai ištrintas!');
    }
}
