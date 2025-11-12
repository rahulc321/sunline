<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'heatpump_commission' => Setting::getValue('heatpump_commission', 0),
            'aircon_commission'   => Setting::getValue('aircon_commission', 0),
            'office_ip_address'   => Setting::getValue('office_ip_address', 0),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'heatpump_commission' => 'required|numeric|min:0',
            'aircon_commission'   => 'required|numeric|min:0',
            'office_ip_address'   => 'nullable',
        ]);

        Setting::setValue('heatpump_commission', $request->heatpump_commission);
        Setting::setValue('aircon_commission', $request->aircon_commission);
        Setting::setValue('office_ip_address', $request->office_ip_address);

        return back()->with('success', 'Settings updated successfully!');
    }
}
