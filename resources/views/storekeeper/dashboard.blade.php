@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Storekeeper Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Expiring Medicines</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $expiringMedicines }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
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
                            <a href="{{ route('storekeeper.stock') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-pills"></i> View Stock
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('storekeeper.stock.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> Add Stock
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('storekeeper.requisitions') }}" class="btn btn-info btn-block">
                                <i class="fas fa-clipboard-list"></i> View Requisitions
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('storekeeper.stock.history') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-history"></i> Stock History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Requisitions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRequisitions ?? [] as $requisition)
                                    <tr>
                                        <td>{{ $requisition->created_at->format('M d, Y') }}</td>
                                        <td>{{ $requisition->medicine->name }}</td>
                                        <td>{{ $requisition->quantity }}</td>
                                        <td>
                                            @if($requisition->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($requisition->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('storekeeper.requisitions.show', $requisition) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent requisitions found.</td>
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