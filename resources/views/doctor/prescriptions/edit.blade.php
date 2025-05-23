@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Prescription</h1>
        <a href="{{ route('doctor.prescriptions.show', $prescription) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Prescription
        </a>
    </div>

    <!-- Prescription Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescription Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('doctor.prescriptions.update', $prescription) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3">{{ old('diagnosis', $prescription->diagnosis) }}</textarea>
                    @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $prescription->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Prescribed Medicines</label>
                    <div id="medicine-items">
                        @foreach($prescription->medicineItems as $index => $item)
                            <div class="card mb-3 medicine-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Medicine</label>
                                                <select name="medicines[{{ $index }}][id]" class="form-control medicine-select" required>
                                                    <option value="">Select Medicine</option>
                                                    @foreach($medicines as $medicine)
                                                        <option value="{{ $medicine->id }}" {{ $item->medicine_id == $medicine->id ? 'selected' : '' }}>
                                                            {{ $medicine->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Dosage</label>
                                                <input type="text" name="medicines[{{ $index }}][dosage]" class="form-control" value="{{ $item->dosage }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Duration</label>
                                                <input type="text" name="medicines[{{ $index }}][duration]" class="form-control" value="{{ $item->duration }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Instructions</label>
                                                <input type="text" name="medicines[{{ $index }}][instructions]" class="form-control" value="{{ $item->instructions }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-block remove-medicine">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" id="add-medicine">
                        <i class="fas fa-plus"></i> Add Medicine
                    </button>
                </div>

                <div class="form-group">
                    <label>Prescribed Tests</label>
                    <div id="test-items">
                        @foreach($prescription->testItems as $index => $item)
                            <div class="card mb-3 test-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <label>Test</label>
                                                <select name="tests[{{ $index }}][id]" class="form-control test-select" required>
                                                    <option value="">Select Test</option>
                                                    @foreach($tests as $test)
                                                        <option value="{{ $test->id }}" {{ $item->test_id == $test->id ? 'selected' : '' }}>
                                                            {{ $test->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-block remove-test">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success" id="add-test">
                        <i class="fas fa-plus"></i> Add Test
                    </button>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let medicineIndex = {{ count($prescription->medicineItems) }};
        let testIndex = {{ count($prescription->testItems) }};

        // Add Medicine
        $('#add-medicine').click(function() {
            const template = `
                <div class="card mb-3 medicine-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Medicine</label>
                                    <select name="medicines[${medicineIndex}][id]" class="form-control medicine-select" required>
                                        <option value="">Select Medicine</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Dosage</label>
                                    <input type="text" name="medicines[${medicineIndex}][dosage]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <input type="text" name="medicines[${medicineIndex}][duration]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Instructions</label>
                                    <input type="text" name="medicines[${medicineIndex}][instructions]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-block remove-medicine">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#medicine-items').append(template);
            medicineIndex++;
        });

        // Add Test
        $('#add-test').click(function() {
            const template = `
                <div class="card mb-3 test-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>Test</label>
                                    <select name="tests[${testIndex}][id]" class="form-control test-select" required>
                                        <option value="">Select Test</option>
                                        @foreach($tests as $test)
                                            <option value="{{ $test->id }}">{{ $test->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-block remove-test">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#test-items').append(template);
            testIndex++;
        });

        // Remove Medicine
        $(document).on('click', '.remove-medicine', function() {
            $(this).closest('.medicine-item').remove();
        });

        // Remove Test
        $(document).on('click', '.remove-test', function() {
            $(this).closest('.test-item').remove();
        });
    });
</script>
@endpush
@endsection 