<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeControlController extends Controller
{
    public function index()
    {
        $interns = \App\Models\Intern::all();
        return view('time_control.index', compact('interns'));
    }

    public function show(\App\Models\Intern $intern)
    {
        $intern->load('timeLogs');
        $logged_hours = $intern->timeLogs->sum('hours_logged');
        $remaining_hours = $intern->max_hours - $logged_hours;

        return view('time_control.show', compact('intern', 'logged_hours', 'remaining_hours'));
    }
}
