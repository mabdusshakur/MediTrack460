@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Prescription Details</h1>
        <a href="{{ route('pharmacist.prescriptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Prescriptions
        </a>
    </div>

    <!-- Prescription Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Patient</div>
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
                                Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($prescription->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($prescription->status === 'dispensed')
                                    <span class="badge bg-success">Dispensed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
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
                        <dt class="col-sm-4">Prescribed On:</dt>
                        <dd class="col-sm-8">{{ $prescription->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Diagnosis:</dt>
                        <dd class="col-sm-8">{{ $prescription->diagnosis ?: 'Not specified' }}</dd>

                        <dt class="col-sm-4">Notes:</dt>
                        <dd class="col-sm-8">{{ $prescription->notes ?: 'No additional notes' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Medicines List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescribed Medicines</h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pharmacist.prescriptions.dispense', $prescription) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                                <th>Instructions</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prescription->medicineItems as $item)
                                <tr>
                                    <td>{{ $item->medicine->name }}</td>
                                    <td>{{ $item->dosage }}</td>
                                    <td>{{ $item->duration }}</td>
                                    <td>{{ $item->instructions }}</td>
                                    <td>
                                        @if($item->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($item->status === 'dispensed')
                                            <span class="badge bg-success">Dispensed</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status === 'pending')
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="medicine_{{ $item->id }}" name="medicine_items[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="medicine_{{ $item->id }}">Dispense</label>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No medicines prescribed.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($prescription->medicineItems->where('status', 'pending')->count() > 0)
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Dispense Selected Medicines
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection 