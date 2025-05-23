<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = Token::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->paginate(10);
            
        return view('receptionist.tokens.index', compact('tokens'));
    }

    public function create(Patient $patient = null)
    {
        if (!$patient) {
            return redirect()->route('receptionist.patients.index')
                ->with('error', 'Please select a patient first to create a token.');
        }

        $doctors = User::where('role', 'doctor')->get();
        return view('receptionist.tokens.create', compact('patient', 'doctors'));
    }

    public function store(Request $request, Patient $patient = null)
    {
        if (!$patient) {
            return redirect()->route('receptionist.patients.index')
                ->with('error', 'Please select a patient first to create a token.');
        }

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

        $token = Token::create([
            'patient_id' => $patient->id,
            'doctor_id' => $validated['doctor_id'],
            'token_number' => $tokenNumber,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        return redirect()->route('receptionist.tokens.show', $token)
            ->with('success', 'Token assigned successfully.');
    }

    public function show(Token $token)
    {
        $token->load(['patient', 'doctor']);
        return view('receptionist.tokens.show', compact('token'));
    }

    public function edit(Token $token)
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('receptionist.tokens.edit', compact('token', 'doctors'));
    }

    public function update(Request $request, Token $token)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $token->update($validated);

        return redirect()->route('receptionist.tokens.show', $token)
            ->with('success', 'Token updated successfully.');
    }

    public function destroy(Token $token)
    {
        $token->delete();
        return redirect()->route('receptionist.tokens.index')
            ->with('success', 'Token deleted successfully.');
    }
} 