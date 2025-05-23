@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Prescriptions</h1>
    </div>

    <!-- Prescriptions List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Prescriptions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Doctor</th>
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
                                <td>{{ $prescription->doctor->name }}</td>
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
                                    <a href="{{ route('receptionist.prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No prescriptions found.</td>
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