<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Setting;

class SettingController extends Controller
{
    private $setting;

    public function __construct()
    {
        $this->setting = new Setting();
    }

    public function store(SettingRequest $request, $parameter)
    {
        return $this->setting->getCurrentUser()->update([$parameter => $request->new_number]);
    }
}
