@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Stock Details</h1>
        <a href="{{ route('storekeeper.stock') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Stock List
        </a>
    </div>

    <!-- Stock Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Medicine Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stock->medicine->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pills fa-2x text-gray-300"></i>
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
                                Current Quantity</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($stock->quantity < 10)
                                    <span class="text-danger">{{ $stock->quantity }}</span>
                                @else
                                    {{ $stock->quantity }}
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
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
                                @if($stock->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
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

    <!-- Stock Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Batch Number:</dt>
                        <dd class="col-sm-8">{{ $stock->batch_number }}</dd>

                        <dt class="col-sm-4">Expiry Date:</dt>
                        <dd class="col-sm-8">
                            @if($stock->expiry_date->diffInMonths(now()) <= 3)
                                <span class="text-danger">{{ $stock->expiry_date->format('M d, Y') }}</span>
                            @else
                                {{ $stock->expiry_date->format('M d, Y') }}
                            @endif
                        </dd>

                        <dt class="col-sm-4">Purchase Date:</dt>
                        <dd class="col-sm-8">{{ $stock->purchase_date->format('M d, Y') }}</dd>

                        <dt class="col-sm-4">Purchase Price:</dt>
                        <dd class="col-sm-8">৳{{ number_format($stock->purchase_price, 2) }}</dd>

                        <dt class="col-sm-4">Added On:</dt>
                        <dd class="col-sm-8">{{ $stock->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Last Updated:</dt>
                        <dd class="col-sm-8">{{ $stock->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock History</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stock->history ?? [] as $history)
                            <tr>
                                <td>{{ $history->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @if($history->type === 'in')
                                        <span class="badge bg-success">Stock In</span>
                                    @else
                                        <span class="badge bg-danger">Stock Out</span>
                                    @endif
                                </td>
                                <td>{{ $history->quantity }}</td>
                                <td>{{ $history->notes ?: 'No notes' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 