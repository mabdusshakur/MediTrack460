@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Medicine Requisitions</h1>
        <div>
            <a href="{{ route('pharmacist.requisitions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Requisition
            </a>
            <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Requisitions List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Requisitions List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requisitions as $requisition)
                            <tr>
                                <td>{{ $requisition->created_at->format('M d, Y') }}</td>
                                <td>{{ $requisition->medicine->name }}</td>
                                <td>{{ $requisition->quantity }}</td>
                                <td>{{ Str::limit($requisition->reason, 50) }}</td>
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
                                    <a href="{{ route('pharmacist.requisitions.show', $requisition) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No requisitions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $requisitions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 