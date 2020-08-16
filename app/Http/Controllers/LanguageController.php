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
            $this->settingModel()->getCurrentUser()->update(['language' => $language]);
        }
        Session::put('language', $language);
    }

    private function settingModel()
    {
        return new Setting;
    }
}
