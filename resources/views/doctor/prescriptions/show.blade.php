@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Prescription Details</h1>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="fas fa-print"></i> Print Prescription
            </button>
            <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Prescriptions
            </a>
        </div>
    </div>

    <!-- Print-friendly Prescription -->
    <div class="card shadow mb-4 print-prescription">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="mb-1">Medical Prescription</h2>
                <p class="text-muted">MediTrack Medical Center</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Patient Information</h5>
                    <p class="mb-1"><strong>Name:</strong> {{ $prescription->patient->name }}</p>
                    <p class="mb-1"><strong>Age:</strong> {{ $prescription->patient->age }} years</p>
                    <p class="mb-1"><strong>Gender:</strong> {{ $prescription->patient->gender }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <h5 class="font-weight-bold">Doctor Information</h5>
                    <p class="mb-1"><strong>Name:</strong> {{ $prescription->doctor->name }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $prescription->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="font-weight-bold">Diagnosis</h5>
                <p>{{ $prescription->diagnosis }}</p>
            </div>

            <div class="mb-4">
                <h5 class="font-weight-bold">Medications</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescription->medicineItems as $item)
                            <tr>
                                <td>{{ $item->medicine->name }}</td>
                                <td>{{ $item->dosage }}</td>
                                <td>{{ $item->frequency }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>{{ $item->instructions ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No medicines prescribed.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($prescription->testItems->count() > 0)
            <div class="mb-4">
                <h5 class="font-weight-bold">Tests</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->testItems as $item)
                            <tr>
                                <td>{{ $item->test->name }}</td>
                                <td>{{ $item->instructions ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            @if($prescription->notes)
            <div class="mb-4">
                <h5 class="font-weight-bold">Additional Notes</h5>
                <p>{{ $prescription->notes }}</p>
            </div>
            @endif

            @if($prescription->next_visit_date)
            <div class="mb-4">
                <h5 class="font-weight-bold">Next Visit</h5>
                <p>{{ $prescription->next_visit_date->format('M d, Y') }}</p>
            </div>
            @endif

            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="border-top pt-3">
                        <p class="mb-0">Doctor's Signature</p>
                        <p class="text-muted">{{ $prescription->doctor->name }}</p>
                    </div>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="border-top pt-3">
                        <p class="mb-0">Date</p>
                        <p class="text-muted">{{ $prescription->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-prescription, .print-prescription * {
            visibility: visible;
        }
        .print-prescription {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .btn {
            display: none !important;
        }
    }
</style>
@endpush
@endsection 