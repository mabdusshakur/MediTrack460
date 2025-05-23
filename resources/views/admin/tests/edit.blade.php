@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Test</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tests.update', $test) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $test->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $test->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="blood" {{ old('category', $test->category) == 'blood' ? 'selected' : '' }}>Blood Test</option>
                                    <option value="urine" {{ old('category', $test->category) == 'urine' ? 'selected' : '' }}>Urine Test</option>
                                    <option value="stool" {{ old('category', $test->category) == 'stool' ? 'selected' : '' }}>Stool Test</option>
                                    <option value="imaging" {{ old('category', $test->category) == 'imaging' ? 'selected' : '' }}>Imaging</option>
                                    <option value="other" {{ old('category', $test->category) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $test->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="result_type" class="form-label">Result Type</label>
                                <select class="form-select @error('result_type') is-invalid @enderror" id="result_type" name="result_type" required>
                                    <option value="">Select Result Type</option>
                                    <option value="numeric" {{ old('result_type', $test->result_type) == 'numeric' ? 'selected' : '' }}>Numeric</option>
                                    <option value="text" {{ old('result_type', $test->result_type) == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="file" {{ old('result_type', $test->result_type) == 'file' ? 'selected' : '' }}>File</option>
                                </select>
                                @error('result_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', $test->unit) }}">
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="normal_range" class="form-label">Normal Range</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" step="0.01" class="form-control @error('normal_range.min') is-invalid @enderror" 
                                            name="normal_range[min]" 
                                            value="{{ old('normal_range.min', is_array($test->normal_range) ? $test->normal_range['min'] : '') }}" 
                                            placeholder="Min value">
                                        @error('normal_range.min')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="number" step="0.01" class="form-control @error('normal_range.max') is-invalid @enderror" 
                                            name="normal_range[max]" 
                                            value="{{ old('normal_range.max', is_array($test->normal_range) ? $test->normal_range['max'] : '') }}" 
                                            placeholder="Max value">
                                        @error('normal_range.max')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <small class="form-text text-muted">Enter minimum and maximum values for the normal range</small>
                            </div>

                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active', $test->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $test->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $test->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Test</button>
                                <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 