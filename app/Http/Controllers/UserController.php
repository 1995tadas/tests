<?php

namespace App\Http\Controllers;

use App\Setting;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $user = User::find(Auth::user()->id);
        $testCount = $user->tests->count();
        $solutionCount = $user->solutions->count();
        $settings = Setting::where('user_id', $user->id)->firstOrFail(['language', 'test_attempts', 'default_questions']);
        return view('user.show', compact('user', 'testCount', 'solutionCount', 'settings'));
    }
}
