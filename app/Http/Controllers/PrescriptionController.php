<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Token;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'medicineItems.medicine', 'testItems.test'])
            ->latest()
            ->paginate(10);
            
        if (Auth::user()->role === 'receptionist') {
            return view('receptionist.prescriptions.index', compact('prescriptions'));
        }
        
        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    public function create(Patient $patient, Token $token)
    {
        $medicines = Medicine::where('status', 'active')->get();
        $tests = Test::where('status', 'active')->get();
        
        return view('doctor.prescriptions.create', compact('patient', 'token', 'medicines', 'tests'));
    }

    public function store(Request $request, Patient $patient, Token $token)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'next_visit_date' => 'nullable|date|after:today',
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
            'medicines.*.duration' => 'required|string',
            'medicines.*.instructions' => 'nullable|string',
            'tests' => 'nullable|array',
            'tests.*.test_id' => 'required|exists:tests,id',
            'tests.*.instructions' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $patient, $token) {
            $prescription = $patient->prescriptions()->create([
                'doctor_id' => Auth::id(),
                'token_id' => $token->id,
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'],
                'next_visit_date' => $validated['next_visit_date'],
            ]);

            // Add medicines
            foreach ($validated['medicines'] as $medicine) {
                $prescription->medicineItems()->create($medicine);
            }

            // Add tests
            if (isset($validated['tests'])) {
                foreach ($validated['tests'] as $test) {
                    $prescription->testItems()->create($test);
                }
            }

            // Update token status
            $token->update(['status' => 'completed']);
        });

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'Prescription created successfully.');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'medicineItems.medicine', 'testItems.test']);
        
        if (Auth::user()->role === 'receptionist') {
            return view('receptionist.prescriptions.show', compact('prescription'));
        }
        
        return view('doctor.prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $medicines = Medicine::where('status', 'active')->get();
        $tests = Test::where('status', 'active')->get();
        
        return view('doctor.prescriptions.edit', compact('prescription', 'medicines', 'tests'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'next_visit_date' => 'nullable|date|after:today',
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
            'medicines.*.duration' => 'required|string',
            'medicines.*.instructions' => 'nullable|string',
            'tests' => 'nullable|array',
            'tests.*.test_id' => 'required|exists:tests,id',
            'tests.*.instructions' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $prescription) {
            $prescription->update([
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'],
                'next_visit_date' => $validated['next_visit_date'],
            ]);

            // Update medicines
            $prescription->medicineItems()->delete();
            foreach ($validated['medicines'] as $medicine) {
                $prescription->medicineItems()->create($medicine);
            }

            // Update tests
            $prescription->testItems()->delete();
            if (isset($validated['tests'])) {
                foreach ($validated['tests'] as $test) {
                    $prescription->testItems()->create($test);
                }
            }
        });

        return redirect()->route('doctor.prescriptions.show', $prescription)
            ->with('success', 'Prescription updated successfully.');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'Prescription deleted successfully.');
    }
} 