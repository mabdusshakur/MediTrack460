@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Test Result</h1>
        <a href="{{ route('lab.tests.show', $testItem) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Test Details
        </a>
    </div>

    <!-- Test Information -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Patient Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testItem->prescription->patient->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Test Name</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testItem->test->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vial fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Completed Date</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $testItem->testResult->performed_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Test Result</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('lab.results.update', $testItem) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="result">Result</label>
                    <textarea name="result" id="result" class="form-control @error('result') is-invalid @enderror" rows="4" required>{{ old('result', $testItem->testResult->result) }}</textarea>
                    @error('result')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="result_file">Result File (Optional)</label>
                    <div class="custom-file">
                        <input type="file" name="result_file" id="result_file" class="custom-file-input @error('result_file') is-invalid @enderror">
                        <label class="custom-file-label" for="result_file">
                            {{ $testItem->testResult->result_file ? 'Current file: ' . basename($testItem->testResult->result_file) : 'Choose new file' }}
                        </label>
                        @error('result_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Supported formats: PDF, JPG, JPEG, PNG. Maximum size: 10MB
                    </small>
                    @if($testItem->testResult->result_file)
                        <div class="mt-2">
                            <a href="{{ route('lab.tests.download', $testItem) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-download"></i> Download Current File
                            </a>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $testItem->testResult->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update file input label with selected filename
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush 