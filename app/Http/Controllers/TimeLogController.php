<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:interns,id',
            'date' => 'required|date',
            'activity_description' => 'required|string',
            'hours_logged' => 'required|numeric|min:0.1',
        ]);

        $timeLog = TimeLog::create($request->all());

        return response()->json(['success' => true, 'log' => $timeLog]);
    }

    public function update(Request $request, TimeLog $timeLog)
    {
        $request->validate([
            'activity_description' => 'required|string',
            'hours_logged' => 'required|numeric|min:0.1',
        ]);

        $timeLog->update($request->only(['activity_description', 'hours_logged']));

        return response()->json(['success' => true, 'log' => $timeLog]);
    }

    public function destroy(TimeLog $timeLog)
    {
        $timeLog->delete();
        return response()->json(['success' => true]);
    }
}
