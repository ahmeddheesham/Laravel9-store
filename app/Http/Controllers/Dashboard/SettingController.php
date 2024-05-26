<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Image;
use Storage;

class SettingController extends Controller
{
    public function index() {
        return view('dashboard.settings.index');
    }
    public function update(SettingUpdateRequest $request ,Setting $setting) 
    {
        // dd($request->all());
        $setting->update($request->validated());
        $imagename = date('Y-m-d') . '.' . $request->logo->extension();


        $logo = Image::make($request->logo->path());
        $logo->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        })->stream();

        Storage::disk('public')->put($imagename, $logo);


        $setting->update(['logo' => 'public/' . $imagename]);

        // dd($logo);








        return redirect()->route('dashboard.settings.index')->with('success' , 'تم تحديث البيانات بنجاح');
    }
}
