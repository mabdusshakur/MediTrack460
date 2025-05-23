@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Medicine Stock</h1>
        <a href="{{ route('storekeeper.stock.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Stock
        </a>
    </div>

    <!-- Stock List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Batch Number</th>
                            <th>Expiry Date</th>
                            <th>Purchase Date</th>
                            <th>Purchase Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            <tr>
                                <td>{{ $stock->medicine->name }}</td>
                                <td>
                                    @if($stock->quantity < 10)
                                        <span class="text-danger">{{ $stock->quantity }}</span>
                                    @else
                                        {{ $stock->quantity }}
                                    @endif
                                </td>
                                <td>{{ $stock->batch_number }}</td>
                                <td>
                                    @if($stock->expiry_date->diffInMonths(now()) <= 3)
                                        <span class="text-danger">{{ $stock->expiry_date->format('M d, Y') }}</span>
                                    @else
                                        {{ $stock->expiry_date->format('M d, Y') }}
                                    @endif
                                </td>
                                <td>{{ $stock->purchase_date->format('M d, Y') }}</td>
                                <td>৳{{ number_format($stock->purchase_price, 2) }}</td>
                                <td>
                                    @if($stock->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('storekeeper.stock.show', $stock) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No stock found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $stocks->links() }}
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
                            <a href="{{ route('storekeeper.stock.history') }}" class="btn btn-info btn-block">
                                <i class="fas fa-history"></i> Stock History
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('storekeeper.requisitions.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clipboard-list"></i> View Requisitions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 