@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Requisition Details</h1>
        <a href="{{ route('pharmacist.requisitions.index') }}" class="btn btn-secondary">
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

                            @if($requisition->status === 'rejected')
                                <dt class="col-sm-4">Rejection Reason:</dt>
                                <dd class="col-sm-8">{{ $requisition->rejection_reason }}</dd>
                            @endif
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 