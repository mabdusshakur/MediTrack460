@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('header', 'Receptionist Dashboard')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('receptionist.patients.*') ? 'active' : '' }}" href="{{ route('receptionist.patients.index') }}">
            <i class="bi bi-people me-2"></i>
            Patients
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('receptionist.tokens.*') ? 'active' : '' }}" href="{{ route('receptionist.tokens.index') }}">
            <i class="bi bi-ticket-perforated me-2"></i>
            Tokens
        </a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Today's Patients</h5>
                    <h2 class="card-text">{{ $todayPatients }}</h2>
                    <a href="{{ route('receptionist.patients.index') }}" class="btn btn-primary">View All</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active Tokens</h5>
                    <h2 class="card-text">{{ $todayTokens->count() }}</h2>
                    <a href="{{ route('receptionist.tokens.index') }}" class="btn btn-primary">Manage Tokens</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Available Doctors</h5>
                    <h2 class="card-text">{{ $activeDoctors }}</h2>
                    <a href="{{ route('receptionist.tokens.index') }}" class="btn btn-primary">Create Token</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Today's Appointments</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Token #</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayTokens as $token)
                                    <tr>
                                        <td>{{ $token->token_number }}</td>
                                        <td>{{ $token->patient->name }}</td>
                                        <td>{{ $token->doctor->name }}</td>
                                        <td>{{ $token->appointment_time->format('h:i A') }}</td>
                                        <td>
                                            @if($token->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($token->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('receptionist.tokens.show', $token) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No appointments for today</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 