<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function index()
    {
        $interns = Intern::with('timeLogs')->get()->map(function ($intern) {
            $logged_hours = $intern->timeLogs->sum('hours_logged');
            $intern->logged_hours = $logged_hours;
            $intern->remaining_hours = max(0, $intern->max_hours - $logged_hours);
            $intern->progress_percent = $intern->max_hours > 0 ? min(100, round(($logged_hours / $intern->max_hours) * 100)) : 0;
            return $intern;
        });

        return view('summary.index', compact('interns'));
    }
}
