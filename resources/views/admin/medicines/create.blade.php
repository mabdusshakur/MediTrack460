@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Medicine</h6>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.medicines.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="generic_name">Generic Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('generic_name') is-invalid @enderror" 
                                        id="generic_name" name="generic_name" value="{{ old('generic_name') }}" required>
                                    @error('generic_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Pain Relief" {{ old('category') == 'Pain Relief' ? 'selected' : '' }}>Pain Relief</option>
                                        <option value="Antibiotics" {{ old('category') == 'Antibiotics' ? 'selected' : '' }}>Antibiotics</option>
                                        <option value="Antiviral" {{ old('category') == 'Antiviral' ? 'selected' : '' }}>Antiviral</option>
                                        <option value="Antifungal" {{ old('category') == 'Antifungal' ? 'selected' : '' }}>Antifungal</option>
                                        <option value="Antihistamine" {{ old('category') == 'Antihistamine' ? 'selected' : '' }}>Antihistamine</option>
                                        <option value="Cardiovascular" {{ old('category') == 'Cardiovascular' ? 'selected' : '' }}>Cardiovascular</option>
                                        <option value="Diabetes" {{ old('category') == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manufacturer">Manufacturer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" 
                                        id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}" required>
                                    @error('manufacturer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit <span class="text-danger">*</span></label>
                                    <select class="form-control @error('unit') is-invalid @enderror" 
                                        id="unit" name="unit" required>
                                        <option value="">Select Unit</option>
                                        <option value="Tablet" {{ old('unit') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                        <option value="Capsule" {{ old('unit') == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                                        <option value="Syrup" {{ old('unit') == 'Syrup' ? 'selected' : '' }}>Syrup</option>
                                        <option value="Injection" {{ old('unit') == 'Injection' ? 'selected' : '' }}>Injection</option>
                                        <option value="Cream" {{ old('unit') == 'Cream' ? 'selected' : '' }}>Cream</option>
                                        <option value="Ointment" {{ old('unit') == 'Ointment' ? 'selected' : '' }}>Ointment</option>
                                        <option value="Drops" {{ old('unit') == 'Drops' ? 'selected' : '' }}>Drops</option>
                                        <option value="Other" {{ old('unit') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" 
                                            class="form-control @error('price') is-invalid @enderror" 
                                            id="price" name="price" value="{{ old('price') }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Medicine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 