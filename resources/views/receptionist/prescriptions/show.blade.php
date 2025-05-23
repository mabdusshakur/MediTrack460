@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Prescription Details</h1>
        <div>
            <a href="{{ route('receptionist.prescriptions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Prescriptions
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prescription->patient->name }}</div>
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
                                Doctor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prescription->doctor->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
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
                                Prescription Date</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $prescription->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescription Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescription Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Diagnosis:</dt>
                        <dd class="col-sm-8">{{ $prescription->diagnosis }}</dd>

                        <dt class="col-sm-4">Notes:</dt>
                        <dd class="col-sm-8">{{ $prescription->notes ?: 'No notes' }}</dd>

                        <dt class="col-sm-4">Next Visit:</dt>
                        <dd class="col-sm-8">
                            @if($prescription->next_visit_date)
                                {{ $prescription->next_visit_date->format('M d, Y') }}
                            @else
                                Not scheduled
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Medicines -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescribed Medicines</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescription->medicineItems as $item)
                            <tr>
                                <td>{{ $item->medicine->name }}</td>
                                <td>{{ $item->dosage }}</td>
                                <td>{{ $item->frequency }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>{{ $item->instructions ?: 'No special instructions' }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'dispensed')
                                        <span class="badge bg-success">Dispensed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No medicines prescribed</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tests -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescribed Tests</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Instructions</th>
                            <th>Status</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescription->testItems as $item)
                            <tr>
                                <td>{{ $item->test->name }}</td>
                                <td>{{ $item->instructions ?: 'No special instructions' }}</td>
                                <td>
                                    @if($item->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($item->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->testResult)
                                        <a href="{{ route('receptionist.test-results.show', $item->testResult) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View Result
                                        </a>
                                    @else
                                        <span class="text-muted">No result yet</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No tests prescribed</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 