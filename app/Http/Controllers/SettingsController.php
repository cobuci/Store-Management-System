<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {      
        return view('admin.settings');
    }

    public static function listarSettings(){

      
        $setting = Settings::first("id")->get();
       

        return $setting;
    }
}
