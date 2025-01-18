<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeFrame;

class TimeFrameController extends Controller
{
    public function index()
    {
        $timeframes = TimeFrame::all();
        return view('timeframes.index', compact('timeframes'));
    }

    public function create()
    {
        return view('timeframes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Event_Type' => 'required|string|max:255',
            'Start_Date' => 'required|date',
            'End_Date' => 'required|date|after_or_equal:Start_Date',
            'Semester' => 'required|string|max:255',
        ]);
        
        TimeFrame::create($request->all());
        
        return redirect()->route('timeframes.index')->with('success', 'Timeframe created successfully.');
        
    }

    public function edit($id)
    {
        $timeframe = TimeFrame::findOrFail($id);
        return view('timeframes.edit', compact('timeframe'));
    }

    public function update(Request $request, $id)
{
    $timeframe = TimeFrame::findOrFail($id);

    $request->validate([
        'Event_Type' => 'required|string|max:255',
        'Start_Date' => 'required|date',
        'End_Date' => 'required|date|after_or_equal:Start_Date',
        'Semester' => 'required|string|max:255',
    ]);

    // Update only the provided fields
    $timeframe->update([
        'Event_Type' => $request->Event_Type,
        'Start_Date' => $request->Start_Date,
        'End_Date' => $request->End_Date,
        'Semester' => $request->Semester,
    ]);

    return redirect()->route('timeframes.index')->with('success', 'Timeframe updated successfully.');
}


    public function destroy($id)
    {
        $timeframe = TimeFrame::findOrFail($id);
        $timeframe->delete();

        return redirect()->route('timeframes.index')->with('success', 'Timeframe deleted successfully.');
    }
}
