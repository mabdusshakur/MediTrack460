@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pending Prescriptions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPrescriptions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Low Stock Medicines</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockMedicines }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Requisitions</div>
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

    <!-- Pending Prescriptions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pending Prescriptions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Medicines</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prescriptions as $prescription)
                                <tr>
                                    <td>{{ $prescription->patient->name }}</td>
                                    <td>{{ $prescription->doctor->name }}</td>
                                    <td>{{ $prescription->created_at->format('M d, Y H:i A') }}</td>
                                    <td>{{ $prescription->medicineItems->count() }}</td>
                                    <td>
                                        <a href="{{ route('pharmacist.prescriptions.show', $prescription) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View & Dispense
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No pending prescriptions</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pharmacist.prescriptions.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-prescription"></i> All Prescriptions
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pharmacist.requisitions.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> New Requisition
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('pharmacist.stock.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-boxes"></i> Stock Management
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 