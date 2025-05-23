@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Token Details</h1>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Token
            </button>
            <a href="{{ route('receptionist.tokens.edit', $token) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Token
            </a>
            <a href="{{ route('receptionist.tokens.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Tokens
            </a>
        </div>
    </div>

    <!-- Print-friendly token template (hidden by default) -->
    <div class="d-none d-print-block">
        <div class="text-center mb-4">
            <h2>Medical Token</h2>
            <div class="border p-4">
                <h3 class="mb-3">Token #{{ $token->token_number }}</h3>
                <div class="row">
                    <div class="col-12">
                        <p class="mb-2"><strong>Patient Name:</strong> {{ $token->patient->name }}</p>
                        <p class="mb-2"><strong>Doctor:</strong> {{ $token->doctor->name }}</p>
                        <p class="mb-2"><strong>Appointment Date:</strong> {{ $token->appointment_date->format('F d, Y') }}</p>
                        <p class="mb-2"><strong>Appointment Time:</strong> {{ $token->appointment_time->format('h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Token Information</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Token Number</th>
                            <td>{{ $token->token_number }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($token->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($token->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Appointment Date</th>
                            <td>{{ $token->appointment_date->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Appointment Time</th>
                            <td>{{ $token->appointment_time->format('h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $token->notes ?? 'No notes' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Patient Information</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $token->patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td>{{ $token->patient->age }} years</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $token->patient->gender }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $token->patient->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $token->patient->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Doctor Information</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <td>{{ $token->doctor->name }}</td>
                        </tr>
                        <tr>
                            <th>Specialization</th>
                            <td>{{ $token->doctor->specialization }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Hide all elements except the print template */
        body * {
            visibility: hidden;
        }
        
        /* Show only the print template */
        .d-print-block,
        .d-print-block * {
            visibility: visible;
        }
        
        /* Position the print template at the top of the page */
        .d-print-block {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        
        /* Hide navigation, buttons, and other UI elements */
        nav,
        .navbar,
        .btn,
        .d-flex,
        .container-fluid > .row,
        .card,
        .card-header,
        .card-body {
            display: none !important;
        }
        
        /* Remove any margins and padding from the body */
        body {
            margin: 0;
            padding: 0;
        }
        
        /* Ensure the print template takes full width */
        .d-print-block .container {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 20px;
        }
    }
</style>
@endsection 