<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function supervisorDashboard()
    {
        return view('supervisor.dashboard');
    }

    public function studentDashboard()
    {
        return view('students.dashboard');
    }
}
