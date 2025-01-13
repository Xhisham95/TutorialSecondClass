<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for bulk user registration.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store new users in bulk from a CSV file.
     */
    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($header) == count($row)) {
                $row = array_combine($header, $row);

                User::create([
                    'UserName' => $row['UserName'],
                    'Email' => $row['Email'],
                    'Password' => Hash::make($row['Password']),
                    'Role' => $row['Role'],
                    'Program' => $row['Program'] ?? null,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Users uploaded successfully.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'UserName' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users,Email,' . $user->id . ',User_ID',
            'Role' => 'required|in:Student,Lecturer,FYP_Coordinator',
        ]);

        $user->update([
            'UserName' => $request->UserName,
            'Email' => $request->Email,
            'Role' => $request->Role,
            'Program' => $request->Program,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Generate a report of active users by their program.
     */
    public function generateReport()
    {
        $users = User::select('Program', \DB::raw('count(*) as total'))
            ->groupBy('Program')
            ->get();

        // Example: Generate a downloadable CSV report
        $filename = 'user_report.csv';
        $handle = fopen($filename, 'w');
        fputcsv($handle, ['Program', 'Total Users']);

        foreach ($users as $user) {
            fputcsv($handle, [$user->Program, $user->total]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend();
    }

    /**
     * Assign lecturers to students.
     */
    public function assignLecturers(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'lecturer_id' => 'required|exists:users,User_ID',
        ]);

        $students = User::whereIn('User_ID', $request->students)->get();
        $lecturer = User::findOrFail($request->lecturer_id);

        foreach ($students as $student) {
            $student->update(['Supervisor_ID' => $lecturer->User_ID]);
        }

        return redirect()->route('users.index')->with('success', 'Lecturer assigned successfully.');
    }
}
