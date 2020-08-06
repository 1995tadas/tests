<?php

namespace App\Http\Controllers;

use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = User::find(Auth::user()->id);
        $testCount = $user->tests->count();
        $solutionCount = $user->solutions->count();
        $setting = Setting::where('user_id', $user->id)->firstOrFail();
        $language = $setting->language;
        $testAttempts = $setting->test_attempt_number;
        return view('user.show', compact('user', 'testCount', 'solutionCount', 'language', 'testAttempts'));
    }

    public function changeAttempts(Request $request)
    {
        $request->validate([
                'user_id' => 'required|integer|exists:settings',
                'test_attempt_number' => 'required|integer|between:1,10',
            ]
        );
        $setting = Setting::where('user_id', $request->user_id)->first();
        $setting->test_attempt_number = $request->test_attempt_number;
        $setting->save();
    }
}
