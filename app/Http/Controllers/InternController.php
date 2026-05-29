<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index(Request $request)
    {
        $query = Intern::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('dui', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('university', 'like', "%{$search}%")
                  ->orWhere('request_number', 'like', "%{$search}%");
        }
        
        $interns = $query->get();
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
            'dui' => 'required|string|regex:/^\d{8}-\d{1}$/|unique:interns',
            'max_hours' => 'required|integer|min:1',
            'supervisor_name' => 'required|string|max:255',
            'university' => 'nullable|string|max:255',
            'request_number' => 'nullable|integer',
            'email' => 'nullable|email|unique:interns',
            'phone' => 'nullable|string|regex:/^\d{4}-\d{4}$/',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:Hombre,Mujer',
            'assigned_unit' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'schedule' => 'nullable|string|max:255',
        ]);

        Intern::create($request->all());
        return redirect()->route('interns.index')->with('success', 'Practicante registrado correctamente.');
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
            'dui' => 'required|string|regex:/^\d{8}-\d{1}$/|unique:interns,dui,' . $intern->id,
            'max_hours' => 'required|integer|min:1',
            'supervisor_name' => 'required|string|max:255',
            'university' => 'nullable|string|max:255',
            'request_number' => 'nullable|integer',
            'email' => 'nullable|email|unique:interns,email,' . $intern->id,
            'phone' => 'nullable|string|regex:/^\d{4}-\d{4}$/',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:Hombre,Mujer',
            'assigned_unit' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'schedule' => 'nullable|string|max:255',
        ]);

        $intern->update($request->all());
        return redirect()->route('interns.index')->with('success', 'Practicante actualizado correctamente.');
    }

    public function destroy(Intern $intern)
    {
        $intern->delete();
        return redirect()->route('interns.index')->with('success', 'Practicante eliminado correctamente.');
    }
}
