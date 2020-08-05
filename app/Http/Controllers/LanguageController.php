<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Support\Facades\Auth;
use Session;

class LanguageController extends Controller
{
    public function setLanguage($language = 'en')
    {
        if (Auth::check()) {
            $setting = Setting::where('user_id', Auth::user()->id)->first();
            $setting->language = $language;
            $setting->save();
        }
        Session::put('language', $language);
    }
}
