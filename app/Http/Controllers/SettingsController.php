<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    function generalIndex(){
        return view('Pages.Management.Master.settings.general');
    }
}
