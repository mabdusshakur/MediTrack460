@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Medicine Requisitions</h1>
        <a href="{{ route('storekeeper.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
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
                            <th>Requested By</th>
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
                                <td>{{ $requisition->requestedBy->name }}</td>
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
                                    <a href="{{ route('storekeeper.requisitions.show', $requisition) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($requisition->status === 'pending')
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $requisition->id }}">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $requisition->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $requisition->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $requisition->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="approveModalLabel{{ $requisition->id }}">Approve Requisition</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('storekeeper.requisitions.approve', $requisition) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Are you sure you want to approve this requisition?</p>
                                                <p><strong>Medicine:</strong> {{ $requisition->medicine->name }}</p>
                                                <p><strong>Quantity:</strong> {{ $requisition->quantity }}</p>
                                                <p><strong>Requested By:</strong> {{ $requisition->requestedBy->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $requisition->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $requisition->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel{{ $requisition->id }}">Reject Requisition</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('storekeeper.requisitions.reject', $requisition) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="notes">Rejection Reason</label>
                                                    <textarea name="notes" id="notes" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No requisitions found.</td>
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