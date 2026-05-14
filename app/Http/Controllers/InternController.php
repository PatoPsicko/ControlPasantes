<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index()
    {
        $interns = Intern::all();
        return view('interns.index', compact('interns'));
    }

    public function create()
    {
        return view('interns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dui' => 'required|string|max:20|unique:interns',
            'max_hours' => 'required|integer|min:1',
            'supervisor_name' => 'required|string|max:255',
        ]);

        Intern::create($request->all());
        return redirect()->route('interns.index')->with('success', 'Pasante registrado correctamente.');
    }

    public function show(Intern $intern)
    {
        // Load time logs for the intern
        $intern->load('timeLogs');
        $logged_hours = $intern->timeLogs->sum('hours_logged');
        $remaining_hours = $intern->max_hours - $logged_hours;

        return view('interns.show', compact('intern', 'logged_hours', 'remaining_hours'));
    }

    public function edit(Intern $intern)
    {
        return view('interns.edit', compact('intern'));
    }

    public function update(Request $request, Intern $intern)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dui' => 'required|string|max:20|unique:interns,dui,' . $intern->id,
            'max_hours' => 'required|integer|min:1',
            'supervisor_name' => 'required|string|max:255',
        ]);

        $intern->update($request->all());
        return redirect()->route('interns.index')->with('success', 'Pasante actualizado correctamente.');
    }

    public function destroy(Intern $intern)
    {
        $intern->delete();
        return redirect()->route('interns.index')->with('success', 'Pasante eliminado correctamente.');
    }
}
