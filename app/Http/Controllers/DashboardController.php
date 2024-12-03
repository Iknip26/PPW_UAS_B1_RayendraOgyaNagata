<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cukup mengembalikan view 'dashboard' tanpa mengirimkan data apa pun
        return view('dashboard');
    }
}