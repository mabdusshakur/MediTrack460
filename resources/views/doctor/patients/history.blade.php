@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Patient History</h1>
        <div>
            <a href="{{ route('doctor.patients.today') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Today's Patients
            </a>
        </div>
    </div>

    <!-- Patient Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Patient Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $patient->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Age & Gender</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $patient->age }} years, {{ $patient->gender }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Contact</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $patient->phone }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescriptions History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescriptions History</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                            <th>Medicines</th>
                            <th>Tests</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                                <td>{{ $prescription->doctor->name }}</td>
                                <td>{{ Str::limit($prescription->diagnosis, 50) }}</td>
                                <td>{{ $prescription->medicineItems->count() }} medicines</td>
                                <td>{{ $prescription->testItems->count() }} tests</td>
                                <td>
                                    <a href="{{ route('doctor.prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No prescription history available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Test Results -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Test Results</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Test Name</th>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testItems as $testItem)
                            <tr>
                                <td>{{ $testItem->created_at->format('M d, Y') }}</td>
                                <td>{{ $testItem->test->name }}</td>
                                <td>
                                    @switch($testItem->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($testItem->status === 'completed' && $testItem->testResult)
                                        {{ Str::limit($testItem->testResult->result, 50) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($testItem->status === 'completed' && $testItem->testResult)
                                        <a href="{{ route('lab.tests.show', $testItem) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No test results available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 