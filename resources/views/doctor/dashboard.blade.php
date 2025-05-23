@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Doctor Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Prescriptions Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Prescriptions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPrescriptions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Prescriptions Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Prescriptions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayPrescriptions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Today's Appointments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayTokens->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Today's Appointments</h6>
            <a href="{{ route('doctor.patients.today') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-list"></i> View All
            </a>
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
                        @forelse($todayTokens as $token)
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
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('doctor.patients.today') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-users"></i> View Today's Patients
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-prescription"></i> View Prescriptions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 