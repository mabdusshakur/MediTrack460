@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Stock</h1>
        <a href="{{ route('storekeeper.stock') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Stock List
        </a>
    </div>

    <!-- Stock Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('storekeeper.stock.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="medicine_id">Medicine</label>
                    <select name="medicine_id" id="medicine_id" class="form-control @error('medicine_id') is-invalid @enderror" required>
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}" {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                                {{ $medicine->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('medicine_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="batch_number">Batch Number</label>
                    <input type="text" name="batch_number" id="batch_number" class="form-control @error('batch_number') is-invalid @enderror" value="{{ old('batch_number') }}" required>
                    @error('batch_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="purchase_price">Purchase Price (৳)</label>
                    <input type="number" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" min="0" step="0.01" required>
                    @error('purchase_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 