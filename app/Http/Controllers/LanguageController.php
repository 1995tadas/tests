<?php

namespace App\Http\Controllers;

use Session;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setLanguage($language = 'en')
    {
        Session::put('language', $language);
    }
}
