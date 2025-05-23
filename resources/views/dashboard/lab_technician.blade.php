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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pending Tests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTests }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vial fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Tests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTests }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Tests -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pending Tests</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Test Name</th>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                    <th>Priority</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tests as $test)
                                <tr>
                                    <td>{{ $test->patient->name }}</td>
                                    <td>{{ $test->test_name }}</td>
                                    <td>{{ $test->requested_by->name }}</td>
                                    <td>{{ $test->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        @if($test->priority === 'high')
                                            <span class="badge bg-danger">High</span>
                                        @elseif($test->priority === 'medium')
                                            <span class="badge bg-warning text-dark">Medium</span>
                                        @else
                                            <span class="badge bg-info text-dark">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('lab_technician.tests.show', $test) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-vial"></i> Process Test
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No pending tests</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Results -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Results</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Test Name</th>
                                    <th>Completed At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentResults as $result)
                                <tr>
                                    <td>{{ $result->patient->name }}</td>
                                    <td>{{ $result->test_name }}</td>
                                    <td>{{ $result->completed_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        @if($result->status === 'normal')
                                            <span class="badge bg-success">Normal</span>
                                        @elseif($result->status === 'abnormal')
                                            <span class="badge bg-danger">Abnormal</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending Review</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('lab_technician.results.show', $result) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent results</td>
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
                            <a href="{{ route('lab_technician.tests.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-vial"></i> All Tests
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lab_technician.results.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-clipboard-check"></i> All Results
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lab_technician.tests.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> New Test
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 