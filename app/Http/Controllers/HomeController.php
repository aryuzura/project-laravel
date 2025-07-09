<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;

class HomeController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return view('home', compact('lombas'));
    }
}
