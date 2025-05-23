@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pharmacist Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pending Prescriptions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPrescriptions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Low Stock Medicines</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockMedicines }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
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
                                Pending Requisitions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingRequisitions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
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
                            <a href="{{ route('pharmacist.prescriptions') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-prescription"></i> View Prescriptions
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('pharmacist.stock') }}" class="btn btn-info btn-block">
                                <i class="fas fa-pills"></i> View Stock
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('pharmacist.requisitions') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clipboard-list"></i> View Requisitions
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('pharmacist.requisitions.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> New Requisition
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Prescriptions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPrescriptions ?? [] as $prescription)
                                    <tr>
                                        <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                                        <td>{{ $prescription->patient->name }}</td>
                                        <td>{{ $prescription->doctor->name }}</td>
                                        <td>
                                            @if($prescription->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($prescription->status === 'dispensed')
                                                <span class="badge bg-success">Dispensed</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('pharmacist.prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent prescriptions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 