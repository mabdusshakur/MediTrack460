@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Today's Patients</h1>
        <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Patients List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokens as $token)
                            <tr>
                                <td>{{ $token->token_number }}</td>
                                <td>{{ $token->patient->name }}</td>
                                <td>{{ $token->patient->age }}</td>
                                <td>{{ $token->patient->gender }}</td>
                                <td>{{ $token->appointment_time->format('h:i A') }}</td>
                                <td>
                                    @switch($token->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($token->status === 'pending')
                                        <a href="{{ route('doctor.prescriptions.create', ['patient' => $token->patient, 'token' => $token]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-prescription"></i> Create Prescription
                                        </a>
                                    @else
                                        <a href="{{ route('doctor.patients.history', $token->patient) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-history"></i> View History
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No appointments for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $tokens->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 