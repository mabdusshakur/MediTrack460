@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Prescriptions</h1>
        <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('doctor.prescriptions.index') }}" method="GET" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="patient">Patient</label>
                        <input type="text" name="patient" id="patient" class="form-control" value="{{ request('patient') }}" placeholder="Search by patient name">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="has_tests">Has Tests</label>
                        <select name="has_tests" id="has_tests" class="form-control">
                            <option value="">All</option>
                            <option value="1" {{ request('has_tests') === '1' ? 'selected' : '' }}>With Tests</option>
                            <option value="0" {{ request('has_tests') === '0' ? 'selected' : '' }}>Without Tests</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Prescriptions List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescriptions List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Diagnosis</th>
                            <th>Medicines</th>
                            <th>Tests</th>
                            <th>Next Visit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                                <td>{{ $prescription->patient->name }}</td>
                                <td>{{ Str::limit($prescription->diagnosis, 50) }}</td>
                                <td>{{ $prescription->medicineItems->count() }} medicines</td>
                                <td>{{ $prescription->testItems->count() }} tests</td>
                                <td>
                                    @if($prescription->next_visit_date)
                                        {{ $prescription->next_visit_date->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('doctor.prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No prescriptions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $prescriptions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set default dates if not set
    if (!document.getElementById('start_date').value) {
        document.getElementById('start_date').value = new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split('T')[0];
    }
    if (!document.getElementById('end_date').value) {
        document.getElementById('end_date').value = new Date().toISOString().split('T')[0];
    }
</script>
@endpush 