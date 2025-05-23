@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pending Prescriptions</h1>
        <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
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
                            <th>Doctor</th>
                            <th>Medicines</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                                <td>{{ $prescription->patient->name }}</td>
                                <td>{{ $prescription->doctor->name }}</td>
                                <td>
                                    @foreach($prescription->medicineItems as $item)
                                        <span class="badge bg-info text-dark">{{ $item->medicine->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($prescription->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($prescription->status === 'dispensed')
                                        <span class="badge bg-success">Dispensed</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pharmacist.prescriptions.show', $prescription) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No pending prescriptions found.</td>
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