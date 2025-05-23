<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('receptionist.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('receptionist.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'medical_history' => 'nullable|array',
            'allergies' => 'nullable|array',
            'emergency_contact' => 'required|string|max:20',
        ]);

        $patient = Patient::create($validated);

        return redirect()->route('receptionist.patients.show', $patient)
            ->with('success', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['tokens.doctor', 'prescriptions.doctor']);
        return view('receptionist.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('receptionist.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'medical_history' => 'nullable|array',
            'allergies' => 'nullable|array',
            'emergency_contact' => 'required|string|max:20',
        ]);

        $patient->update($validated);

        return redirect()->route('receptionist.patients.show', $patient)
            ->with('success', 'Patient information updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('receptionist.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $patients = Patient::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->paginate(10);
            
        return view('receptionist.patients.index', compact('patients', 'query'));
    }
} 