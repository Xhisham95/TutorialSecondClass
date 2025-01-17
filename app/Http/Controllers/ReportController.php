<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReportController extends Controller
{
    public function userReport()
    {
        // Fetch users grouped by program
        $usersByProgram = User::select('Program')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('Program')
            ->get();

        return view('admin.reports.users', compact('usersByProgram'));
    }

    public function exportUserReport()
    {
        // Fetch users grouped by program
        $usersByProgram = User::select('Program')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('Program')
            ->get();

        // Generate CSV content
        $csvHeader = "Program,Total Users\n";
        $csvContent = $usersByProgram->reduce(function ($carry, $program) {
            return $carry . ($program->Program ?? 'Not Assigned') . ',' . $program->total . "\n";
        }, $csvHeader);

        // Return CSV response
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="user_report_by_program.csv"');
    }
}
