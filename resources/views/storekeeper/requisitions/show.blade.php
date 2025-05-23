@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Requisition Details</h1>
        <a href="{{ route('storekeeper.requisitions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Requisitions
        </a>
    </div>

    <!-- Requisition Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Medicine</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $requisition->medicine->name }}</div>
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
                                Quantity</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $requisition->quantity }}</div>
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
                                @if($requisition->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($requisition->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
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

    <!-- Requisition Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Requisition Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Requested By:</dt>
                        <dd class="col-sm-8">{{ $requisition->requestedBy->name }}</dd>

                        <dt class="col-sm-4">Requested On:</dt>
                        <dd class="col-sm-8">{{ $requisition->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Reason:</dt>
                        <dd class="col-sm-8">{{ $requisition->reason }}</dd>

                        @if($requisition->notes)
                            <dt class="col-sm-4">Notes:</dt>
                            <dd class="col-sm-8">{{ $requisition->notes }}</dd>
                        @endif

                        @if($requisition->status !== 'pending')
                            <dt class="col-sm-4">Processed By:</dt>
                            <dd class="col-sm-8">{{ $requisition->approvedBy->name }}</dd>

                            <dt class="col-sm-4">Processed On:</dt>
                            <dd class="col-sm-8">{{ $requisition->approved_at->format('M d, Y H:i') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($requisition->status === 'pending')
        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('storekeeper.requisitions.approve', $requisition) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this requisition?')">
                        <i class="fas fa-check"></i> Approve Requisition
                    </button>
                </form>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                    <i class="fas fa-times"></i> Reject Requisition
                </button>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Requisition</h5>
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
    @endif
</div>
@endsection 