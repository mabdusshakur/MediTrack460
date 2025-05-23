@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Completed Tests</h1>
        <a href="{{ route('lab.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Completed Tests List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Completed Tests List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Test</th>
                            <th>Result</th>
                            <th>Completed At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testItems as $testItem)
                            <tr>
                                <td>{{ $testItem->created_at->format('M d, Y') }}</td>
                                <td>{{ $testItem->prescription->patient->name }}</td>
                                <td>{{ $testItem->test->name }}</td>
                                <td>{{ Str::limit($testItem->testResult->result, 50) }}</td>
                                <td>{{ $testItem->testResult->performed_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('lab.tests.show', $testItem) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                    <a href="{{ route('lab.results.edit', $testItem) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit Result
                                    </a>
                                    @if($testItem->testResult->result_file)
                                        <a href="{{ route('lab.tests.download', $testItem) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No completed tests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $testItems->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 