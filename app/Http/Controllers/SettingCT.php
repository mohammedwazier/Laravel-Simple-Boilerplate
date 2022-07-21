<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SettingModel;

use Main;
use Alert;

class SettingCT extends Controller
{
    public function index()
    {
        $setting = SettingModel::all()->each(function($st, $key){
            $st->st_value = Main::SerializeSetting($st->st_value, $st->st_type);
            return $st;
        });
        return view('dashboard.config.setting.index', ['setting' => $setting]);
    }

    public function store(Request $request)
    {
        $setting = new SettingModel;
        $setting->st_key = $request->key;
        $setting->st_value = $request->value;
        $setting->st_type = $request->type;
        $setting->save();

        Alert::success('Sukses', 'Sukses menambahkan Setting Baru');
        return redirect()->route('dashboard.config.setting.index');
    }

    public function edit($id)
    {
        $setting = SettingModel::findOrFail($id);
        return view('dashboard.config.setting.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $setting = SettingModel::findOrFail($id);
            // $setting->st_key = $request->key;
            $setting->st_value = $request->value;
            $setting->st_type = $request->type;
            $setting->save();

            Alert::success('Sukses', 'Sukses mengubah Setting');
        } catch (\Throwable $th) {
            Alert::error("Gagal", "Gagal mengubah Setting");
        }
        return redirect()->route('dashboard.config.setting.index');
    }

    public function destroy($id)
    {
        try {
            $setting = SettingModel::findOrFail($id);
            $setting->delete();

            Alert::success("Sukses", "Sukses menghapus Setting");
        } catch (\Throwable $th) {
            Alert::error("Gagal", "Gagal menghapus Setting");
        }

        return redirect()->route('dashboard.config.setting.index');
    }
}
