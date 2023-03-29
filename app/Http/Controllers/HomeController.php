<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('index');
    }
}
