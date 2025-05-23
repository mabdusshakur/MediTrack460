@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Medicine</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.medicines.update', $medicine) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $medicine->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="generic_name" class="form-label">Generic Name</label>
                                <input type="text" class="form-control @error('generic_name') is-invalid @enderror" id="generic_name" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" required>
                                @error('generic_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="tablet" {{ old('category', $medicine->category) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                    <option value="capsule" {{ old('category', $medicine->category) == 'capsule' ? 'selected' : '' }}>Capsule</option>
                                    <option value="syrup" {{ old('category', $medicine->category) == 'syrup' ? 'selected' : '' }}>Syrup</option>
                                    <option value="injection" {{ old('category', $medicine->category) == 'injection' ? 'selected' : '' }}>Injection</option>
                                    <option value="cream" {{ old('category', $medicine->category) == 'cream' ? 'selected' : '' }}>Cream</option>
                                    <option value="ointment" {{ old('category', $medicine->category) == 'ointment' ? 'selected' : '' }}>Ointment</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="manufacturer" class="form-label">Manufacturer</label>
                                <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $medicine->manufacturer) }}" required>
                                @error('manufacturer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                    <option value="">Select Unit</option>
                                    <option value="piece" {{ old('unit', $medicine->unit) == 'piece' ? 'selected' : '' }}>Piece</option>
                                    <option value="strip" {{ old('unit', $medicine->unit) == 'strip' ? 'selected' : '' }}>Strip</option>
                                    <option value="bottle" {{ old('unit', $medicine->unit) == 'bottle' ? 'selected' : '' }}>Bottle</option>
                                    <option value="box" {{ old('unit', $medicine->unit) == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="tube" {{ old('unit', $medicine->unit) == 'tube' ? 'selected' : '' }}>Tube</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $medicine->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $medicine->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active', $medicine->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $medicine->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Medicine</button>
                                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 