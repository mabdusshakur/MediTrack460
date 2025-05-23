@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Stock History</h1>
        <a href="{{ route('storekeeper.stock.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Stock List
        </a>
    </div>

    <!-- Stock History List -->
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
                            <th>Medicine</th>
                            <th>Batch Number</th>
                            <th>Quantity</th>
                            <th>Expiry Date</th>
                            <th>Purchase Date</th>
                            <th>Purchase Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            <tr>
                                <td>{{ $stock->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $stock->medicine->name }}</td>
                                <td>{{ $stock->batch_number }}</td>
                                <td>
                                    @if($stock->quantity < 10)
                                        <span class="text-danger">{{ $stock->quantity }}</span>
                                    @else
                                        {{ $stock->quantity }}
                                    @endif
                                </td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No stock history found.</td>
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
</div>
@endsection 