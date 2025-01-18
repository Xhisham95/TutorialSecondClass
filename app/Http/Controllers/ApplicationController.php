<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTopic;

class ApplicationController extends Controller
{
    public function index()
{
    $applications = \DB::table('applications')
        ->join('project_topics', 'applications.topic_id', '=', 'project_topics.id')
        ->join('users', 'applications.student_id', '=', 'users.id')
        ->where('project_topics.Supervisor_ID', auth()->user()->id)
        ->where('applications.status', 'Pending') // Only fetch pending applications
        ->select(
            'applications.id as application_id',
            'users.UserName as student_name',
            'project_topics.Topic_Title as topic_title',
            'applications.remarks',
            'applications.status'
        )
        ->get();

    return view('supervisor.applications', compact('applications'));
}



public function review(Request $request, $id)
{
    // Fetch the application, including the supervisor_id and student_id
    $application = \DB::table('applications')
        ->join('project_topics', 'applications.topic_id', '=', 'project_topics.id')
        ->where('applications.id', $id)
        ->first(['applications.id as application_id', 'project_topics.Supervisor_ID as supervisor_id', 'applications.topic_id', 'applications.student_id']);

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Fetch the quota for the supervisor
    $quota = \DB::table('quotas')->where('Supervisor_ID', $application->supervisor_id)->first();

    if (!$quota) {
        return redirect()->back()->with('error', 'Quota record not found for this supervisor.');
    }

    if ($request->action === 'accept') {
        // Check if current_quota has reached QuotaNumber
        if ($quota->current_quota >= $quota->QuotaNumber) {
            return redirect()->back()->with('error', 'Quota limit reached. Cannot accept more applications.');
        }

        // Update the application status
        \DB::table('applications')->where('id', $id)->update([
            'status' => 'Accepted',
            'updated_at' => now(),
        ]);

        // Update the topic status to "Closed" and assign the student ID to the topic
        \DB::table('project_topics')->where('id', $application->topic_id)->update([
            'Status' => 'Closed',
            'Student_ID' => $application->student_id,
        ]);

        // Increment supervisor current_quota
        \DB::table('quotas')->where('Supervisor_ID', $application->supervisor_id)->increment('current_quota');

        return redirect()->back()->with('success', 'Application accepted successfully.');
    }

    if ($request->action === 'reject') {
        // Update the application status
        \DB::table('applications')->where('id', $id)->update([
            'status' => 'Rejected',
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Application rejected successfully.');
    }

    return redirect()->back()->with('error', 'Invalid action.');
}







}
