<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function index()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->save();
        }
        return view('settings', compact('setting'));
    }

    function update(Request $request)
    {

        $setting = Setting::first();
        $setting->logo_db_name = $request->logo_db_name;
        $setting->company_name = $request->company_name;
        $setting->logo_donem_no = $request->logo_donem_no;
        $setting->logo_firma_no = $request->logo_firma_no;
        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $file->store('logos', 'public');
            $setting->logo_path = $file->store('logos', 'public');
        }
        $setting->save();
        Helper::setSelectedDbName($setting->logo_db_name);
        return redirect()->route('settings');
    }
}
