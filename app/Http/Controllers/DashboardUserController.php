<?php

namespace App\Http\Controllers;

class DashboardUserController extends Controller
{
    public function index()
    {
        return view('user-dashboard.index');
    }
}
