<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class StartController extends Controller
{
    public function create()
    {
        return view('start');
    }
}
