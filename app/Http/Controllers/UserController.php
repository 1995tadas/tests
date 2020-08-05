<?php

namespace App\Http\Controllers;

use App\Setting;
use App\User;
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
        $language = Setting::where('user_id', $user->id)->firstOrFail('language')->language;
        return view('user.show', compact('user', 'testCount', 'solutionCount','language'));
    }
}
