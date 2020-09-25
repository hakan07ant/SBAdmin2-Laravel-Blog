<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\File;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::find(1);
        return view('back.config.index', compact('config'));
    }

    public function update(Request $request)
    {
        $config = Config::findOrFail(1);
        $config->title = $request->title;
        $config->active = $request->active;
        $config->facebook = $request->facebook;
        $config->youtube = $request->youtube;
        $config->instagram = $request->instagram;
        $config->twitter = $request->twitter;
        $config->github = $request->github;
        $config->gitlab = $request->gitlab;
        $config->linkedin = $request->linkedin;

        if ($request->hasFile('logo')) {
            if (File::exists($config->logo)) {
                File::delete(public_path($config->logo));
            }
            $imageName = str_slug($request->title) . '_logo' . '.' . $request->logo->getClientOriginalExtension();
            //dd($imageName);
            $request->logo->move(public_path('uploads/config'), $imageName);
            $config->logo = 'uploads/config/' . $imageName;
        }

        if ($request->hasFile('favicon')) {
            if (File::exists($config->favicon)) {
                File::delete(public_path($config->favicon));
            }
            $imageName = str_slug($request->title) . '_favicon' . '.' . $request->favicon->getClientOriginalExtension();
            //dd($imageName);
            $request->favicon->move(public_path('uploads/config'), $imageName);
            $config->favicon = 'uploads/config/' . $imageName;
        }
        $config->save();
        toastr()->success('Başarılı.', 'Sayfa ayarları güncellendi.');

        return view('back.config.index', compact('config'));
    }
}
