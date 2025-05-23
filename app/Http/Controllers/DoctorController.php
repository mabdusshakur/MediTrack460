<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Test;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $todayTokens = Token::with(['patient', 'prescription'])
            ->where('doctor_id', Auth::id())
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();
            
        $totalPrescriptions = Prescription::where('doctor_id', Auth::id())->count();
        $todayPrescriptions = Prescription::where('doctor_id', Auth::id())
            ->whereDate('created_at', today())
            ->count();
            
        return view('dashboard.doctor', compact('todayTokens', 'totalPrescriptions', 'todayPrescriptions'));
    }

    public function todayPatients()
    {
        $tokens = Token::with(['patient'])
            ->where('doctor_id', Auth::id())
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->paginate(10);
            
        return view('doctor.patients.today', compact('tokens'));
    }

    public function patientHistory(Patient $patient)
    {
        $patient->load([
            'tokens.doctor',
            'prescriptions.doctor',
            'prescriptions.medicineItems.medicine',
            'prescriptions.testItems.test',
            'prescriptions.testItems.testResult'
        ]);
        
        // Get all test items from prescriptions
        $testItems = $patient->prescriptions->flatMap(function ($prescription) {
            return $prescription->testItems;
        });
        
        return view('doctor.patients.history', compact('patient', 'testItems'));
    }

    public function createPrescription(Patient $patient, Token $token)
    {
        $medicines = Medicine::where('status', 'active')->get();
        $tests = Test::where('status', 'active')->get();
        
        return view('doctor.prescriptions.create', compact('patient', 'token', 'medicines', 'tests'));
    }

    public function storePrescription(Request $request, Patient $patient, Token $token)
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

        return redirect()->route('doctor.dashboard')
            ->with('success', 'Prescription created successfully.');
    }

    public function prescriptions()
    {
        $prescriptions = Prescription::with(['patient', 'medicineItems.medicine', 'testItems.test'])
            ->where('doctor_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    public function showPrescription(Prescription $prescription)
    {
        $prescription->load(['patient', 'medicineItems.medicine', 'testItems.test']);
        return view('doctor.prescriptions.show', compact('prescription'));
    }
} 