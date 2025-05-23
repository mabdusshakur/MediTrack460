@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Test Details</h6>
                    <div>
                        <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $test->name }}</td>
                                </tr>
                                <tr>
                                    <th>Code</th>
                                    <td>{{ $test->code }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ ucfirst($test->category) }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ number_format($test->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Result Type</th>
                                    <td>{{ ucfirst($test->result_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>{{ $test->unit }}</td>
                                </tr>
                                <tr>
                                    <th>Normal Range</th>
                                    <td>
                                        @if(is_array($test->normal_range))
                                            @foreach($test->normal_range as $key => $value)
                                                <div>{{ ucfirst($key) }}: {{ $value }}</div>
                                            @endforeach
                                        @else
                                            {{ $test->normal_range }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($test->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $test->description }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $test->created_at->format('M d, Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $test->updated_at->format('M d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Test History -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Test History</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Result</th>
                                            <th>Status</th>
                                            <th>Performed By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($test->testItems as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('M d, Y H:i A') }}</td>
                                            <td>{{ $item->prescription->patient->name }}</td>
                                            <td>{{ $item->prescription->doctor->name }}</td>
                                            <td>
                                                @if($item->result)
                                                    @if($test->result_type === 'file')
                                                        <a href="{{ route('lab.results.download', $item->result) }}" class="btn btn-info btn-sm">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        {{ $item->result->result }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($item->status === 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->result && $item->result->performed_by)
                                                    {{ $item->result->performedBy->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No test history found</td>
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
    </div>
</div>
@endsection 