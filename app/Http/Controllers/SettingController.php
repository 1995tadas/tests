<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function store(Request $request, $parameter)
    {
        $request->validate($this->rules($parameter));
        $setting = Setting::where('user_id', Auth::user()->id)->first();
        $setting->update([$parameter => $request->new_number]);
    }

    private function rules($parameter = null)
    {
        $rules = [
            'new_number' => 'required|integer',
        ];
        if ($parameter === 'test_attempts') {
            $rules['new_number'] .= '|between:1,10';
        } else if ($parameter === 'default_questions') {
            $rules['new_number'] .= '|between:2,8';
        } else {
            return false;
        }

        return $rules;
    }
}
