<?php

namespace App\Http\Controllers;

use App\Services\RequestDetector;
use Illuminate\Http\Request;

class About extends Controller
{
    public function index(RequestDetector $detector) {
        $detector->init();
        return view('about');
    }
}
