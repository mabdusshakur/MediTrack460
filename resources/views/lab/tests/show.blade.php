@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Test Details</h1>
        <div>
            @if($testItem->status === 'pending')
                <a href="{{ route('lab.results.create', $testItem) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Result
                </a>
            @else
                <a href="{{ route('lab.results.edit', $testItem) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Result
                </a>
            @endif
            <a href="{{ $testItem->status === 'pending' ? route('lab.tests.pending') : route('lab.tests.completed') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Tests
            </a>
        </div>
    </div>

    <!-- Test Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Patient Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testItem->prescription->patient->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                Test Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testItem->test->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vial fa-2x text-gray-300"></i>
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
                                @if($testItem->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
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

    <!-- Test Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Test Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Requested Date:</dt>
                        <dd class="col-sm-8">{{ $testItem->created_at->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-4">Instructions:</dt>
                        <dd class="col-sm-8">{{ $testItem->instructions ?: 'No special instructions' }}</dd>

                        @if($testItem->status === 'completed')
                            <dt class="col-sm-4">Completed Date:</dt>
                            <dd class="col-sm-8">{{ $testItem->testResult->performed_at->format('M d, Y H:i') }}</dd>

                            <dt class="col-sm-4">Performed By:</dt>
                            <dd class="col-sm-8">{{ $testItem->testResult->performedBy->name }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($testItem->status === 'completed')
        <!-- Test Result -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Test Result</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <dl class="row">
                            <dt class="col-sm-2">Result:</dt>
                            <dd class="col-sm-10">{{ $testItem->testResult->result }}</dd>

                            @if($testItem->testResult->notes)
                                <dt class="col-sm-2">Notes:</dt>
                                <dd class="col-sm-10">{{ $testItem->testResult->notes }}</dd>
                            @endif

                            @if($testItem->testResult->result_file)
                                <dt class="col-sm-2">Result File:</dt>
                                <dd class="col-sm-10">
                                    <a href="{{ route('lab.tests.download', $testItem) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Download Result File
                                    </a>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 