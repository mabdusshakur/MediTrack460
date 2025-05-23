@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Medicine Details</h6>
                    <div>
                        <a href="{{ route('admin.medicines.edit', $medicine) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary btn-sm">
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
                                    <td>{{ $medicine->name }}</td>
                                </tr>
                                <tr>
                                    <th>Generic Name</th>
                                    <td>{{ $medicine->generic_name }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ ucfirst($medicine->category) }}</td>
                                </tr>
                                <tr>
                                    <th>Manufacturer</th>
                                    <td>{{ $medicine->manufacturer }}</td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>{{ ucfirst($medicine->unit) }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ number_format($medicine->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($medicine->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $medicine->description }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $medicine->created_at->format('M d, Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $medicine->updated_at->format('M d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Stock History -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Stock History</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Reference</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($medicine->stockHistory as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('M d, Y H:i A') }}</td>
                                            <td>
                                                @if($history->type === 'in')
                                                    <span class="badge bg-success">Stock In</span>
                                                @else
                                                    <span class="badge bg-danger">Stock Out</span>
                                                @endif
                                            </td>
                                            <td>{{ $history->quantity }}</td>
                                            <td>{{ $history->reference }}</td>
                                            <td>{{ $history->notes }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No stock history found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription History -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Prescription History</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($medicine->prescriptionItems as $item)
                                        <tr>
                                            <td>{{ $item->prescription->created_at->format('M d, Y H:i A') }}</td>
                                            <td>{{ $item->prescription->patient->name }}</td>
                                            <td>{{ $item->prescription->doctor->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                @if($item->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($item->status === 'dispensed')
                                                    <span class="badge bg-success">Dispensed</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No prescription history found</td>
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