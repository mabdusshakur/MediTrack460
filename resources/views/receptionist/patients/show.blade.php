@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Patient Details</h1>
        <div>
            <a href="{{ route('receptionist.tokens.create', $patient) }}" class="btn btn-success">
                <i class="fas fa-ticket-alt"></i> Create Token
            </a>
            <a href="{{ route('receptionist.patients.edit', $patient) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Patient
            </a>
            <a href="{{ route('receptionist.patients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Patients
            </a>
        </div>
    </div>

    <!-- Patient Information -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $patient->name }}</p>
                            <p><strong>Email:</strong> {{ $patient->email }}</p>
                            <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                            <p><strong>Emergency Contact:</strong> {{ $patient->emergency_contact }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Age:</strong> {{ $patient->age }} years</p>
                            <p><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</p>
                            <p><strong>Blood Group:</strong> {{ $patient->blood_group }}</p>
                            <p><strong>Address:</strong> {{ $patient->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Medical Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Medical History:</strong></p>
                            @if($patient->medical_history)
                                <ul>
                                    @foreach($patient->medical_history as $condition)
                                        <li>{{ $condition }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No medical history recorded</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>Allergies:</strong></p>
                            @if($patient->allergies)
                                <ul>
                                    @foreach($patient->allergies as $allergy)
                                        <li>{{ $allergy }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No allergies recorded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Medical Records</h6>
        </div>
        <div class="card-body">
            @if($patient->prescriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Diagnosis</th>
                                <th>Medicines</th>
                                <th>Tests</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->prescriptions as $prescription)
                                <tr>
                                    <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                                    <td>{{ $prescription->doctor->name }}</td>
                                    <td>{{ $prescription->diagnosis }}</td>
                                    <td>
                                        @foreach($prescription->medicineItems as $medicineItem)
                                            <span class="badge bg-info text-dark">{{ $medicineItem->medicine->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($prescription->testItems as $testItem)
                                            <span class="badge bg-info text-dark">{{ $testItem->test->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($prescription->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($prescription->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('receptionist.prescriptions.show', $prescription) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No medical records found</p>
            @endif
        </div>
    </div>
</div>
@endsection 