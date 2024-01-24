<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {

        $settings = Setting::checkSettings();
        $settings = SettingResource::make($settings);
        return  response()->json(['data' => $settings , 'error' => '']);
        
    }
}
