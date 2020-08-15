<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function store(SettingRequest $request, $parameter)
    {
        $setting = Setting::where('user_id', Auth::user()->id)->first();
        $setting->update([$parameter => $request->new_number]);
    }
}
