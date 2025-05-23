<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $todayTokens = Token::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();
            
        $totalPatients = Patient::count();
        $todayPatients = Token::whereDate('appointment_date', today())->count();
        $activeDoctors = User::where('role', 'doctor')->count();
        
        return view('dashboard.receptionist', compact('todayTokens', 'totalPatients', 'todayPatients', 'activeDoctors'));
    }

    public function patients()
    {
        $patients = Patient::latest()->paginate(10);
        return view('receptionist.patients.index', compact('patients'));
    }

    public function createPatient()
    {
        return view('receptionist.patients.create');
    }

    public function storePatient(Request $request)
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

    public function showPatient(Patient $patient)
    {
        $patient->load(['tokens.doctor', 'prescriptions.doctor']);
        return view('receptionist.patients.show', compact('patient'));
    }

    public function createToken(Patient $patient)
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('receptionist.tokens.create', compact('patient', 'doctors'));
    }

    public function storeToken(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Generate token number using date and sequence
        $date = date('Ymd');
        $lastToken = Token::where('token_number', 'like', $date . '%')
            ->orderBy('token_number', 'desc')
            ->first();
            
        if ($lastToken) {
            $sequence = (int)substr($lastToken->token_number, -4) + 1;
        } else {
            $sequence = 1;
        }
        
        $tokenNumber = $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $token = $patient->tokens()->create([
            'doctor_id' => $validated['doctor_id'],
            'token_number' => $tokenNumber,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        return redirect()->route('receptionist.dashboard')
            ->with('success', 'Token assigned successfully.');
    }

    public function searchPatients(Request $request)
    {
        $query = $request->input('query');
        
        $patients = Patient::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->paginate(10);
            
        return view('receptionist.patients.index', compact('patients', 'query'));
    }
} 