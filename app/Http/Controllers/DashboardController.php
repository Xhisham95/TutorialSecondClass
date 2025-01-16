<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    public function supervisorDashboard()
    {
        return view('supervisor.dashboard');
    }

    public function studentDashboard()
    {
        return view('dashboard.student');
    }
}
