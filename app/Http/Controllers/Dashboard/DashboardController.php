<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = 'MOHAMED';
        $title = "safadi";


        return view('dashboard.index', compact('user'));
    }
}
