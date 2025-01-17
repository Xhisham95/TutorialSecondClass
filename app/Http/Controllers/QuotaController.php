<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quota;

class QuotaController extends Controller
{
    public function index()
    {
        $quotas = Quota::with('supervisor')->get(); // Load all quotas with related supervisor details
        return view('quota.index', compact('quotas'));
    }

    public function create()
    {
        return view('quota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Supervisor_ID' => 'required|exists:users,id',
            'QuotaNumber' => 'required|integer|min:1|max:15',
            'Start_Date' => 'required|date',
            'End_Date' => 'required|date|after_or_equal:Start_Date',
        ]);

        Quota::create($request->all());

        return redirect()->route('quota.index')->with('success', 'Quota created successfully.');
    }

    public function edit($id)
    {
        $quota = Quota::findOrFail($id);
        return view('quota.edit', compact('quota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'QuotaNumber' => 'required|integer|min:1|max:15',
            'Start_Date' => 'required|date',
            'End_Date' => 'required|date|after_or_equal:Start_Date',
        ]);

        $quota = Quota::findOrFail($id);
        $quota->update($request->all());

        return redirect()->route('quota.index')->with('success', 'Quota updated successfully.');
    }

    public function destroy($id)
    {
        $quota = Quota::findOrFail($id);
        $quota->delete();

        return redirect()->route('quota.index')->with('success', 'Quota deleted successfully.');
    }
}

