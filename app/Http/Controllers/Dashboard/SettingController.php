<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use PhpParser\Node\Stmt\Foreach_;
use Termwind\Components\Dd;
use Illuminate\Support\Str;

// use function Ramsey\Uuid\v1;

class SettingController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        $this->authorize('view', $setting);
        return view('dashboard.settings');
    }
    // public function update(Request $request, Setting $setting)
    // {
    //     $data = [
    //         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //         'favicon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //         'facebook' => 'nullable|string',
    //         'instagram' => 'nullable|string',
    //         'phone' => 'nullable|string',
    //         'email' => 'nullable|email',
    //     ];

    //     foreach (config('app.languages') as $key => $value) {
    //         $data[$key . '*.title'] = 'nullable|string';
    //         $data[$key . '*.content'] = 'nullable|string';
    //         $data[$key . '*.address'] = 'nullable|string';
    //     }
    //     $validatedData = $request->validate($data);
    //     $setting->update($request->except('image', 'favicon', '_token'));
    //     if ($request->file('logo')) {
    //         $file = $request->file('logo');
    //         $filename = Str::uuid() . $file->getClientOriginalName();
    //         $file->move(public_path('images'), $filename);
    //         $path = 'images/' . $filename;
    //         $setting->update(['logo' => $path]);
    //     }
    //     if ($request->file('favicon')) {
    //         $file = $request->file('favicon');
    //         $filename = Str::uuid() . $file->getClientOriginalName();
    //         $file->move(public_path('images'), $filename);
    //         $path = 'images/' . $filename;
    //         $setting->update(['favicon' => $path]);
    //     }
    //     return redirect()->route('dashboard.settings');
    // }


public function update(Request $request, Setting $setting)
{
    $data = $this->getValidationRules();

    $validatedData = $request->validate($data);

    $this->updateSettingData($setting, $request);
    
    $this->uploadFile($request, 'logo', 'images', 'logo', $setting);
    $this->uploadFile($request, 'favicon', 'images', 'favicon', $setting);

    return redirect()->route('dashboard.settings');
}

private function getValidationRules()
{
    $data = [
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'favicon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'facebook' => 'nullable|string',
        'instagram' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
    ];

    foreach (config('app.languages') as $key => $value) {
        $data[$key . '*.title'] = 'nullable|string';
        $data[$key . '*.content'] = 'nullable|string';
        $data[$key . '*.address'] = 'nullable|string';
    }

    return $data;
}

private function updateSettingData(Setting $setting, Request $request)
{
    $setting->update($request->except('image', 'favicon', '_token'));
}

private function uploadFile(Request $request, $fileKey, $destination, $field, Setting $setting)
{
    if ($request->file($fileKey)) {
        $file = $request->file($fileKey);
        $filename = Str::uuid() . $file->getClientOriginalName();
        $file->move(public_path($destination), $filename);
        $path = $destination . '/' . $filename;
        $setting->update([$field => $path]);
    }
}

}

