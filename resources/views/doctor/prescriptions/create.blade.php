@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Prescription for {{ $patient->name }}</h5>
                    <a href="{{ route('doctor.prescriptions.index') }}" class="btn btn-secondary">Back to Prescriptions</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('doctor.prescriptions.store', ['patient' => $patient->id, 'token' => $token->id]) }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis</label>
                                    <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control @error('diagnosis') is-invalid @enderror" required>{{ old('diagnosis') }}</textarea>
                                    @error('diagnosis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="next_visit_date">Next Visit Date</label>
                                    <input type="date" name="next_visit_date" id="next_visit_date" class="form-control @error('next_visit_date') is-invalid @enderror" value="{{ old('next_visit_date') }}">
                                    @error('next_visit_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Medicines</h6>
                            </div>
                            <div class="card-body">
                                <div id="medicines-container">
                                    <div class="medicine-item mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Medicine</label>
                                                    <select name="medicines[0][medicine_id]" class="form-control @error('medicines.0.medicine_id') is-invalid @enderror" required>
                                                        <option value="">Select Medicine</option>
                                                        @foreach($medicines as $medicine)
                                                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('medicines.0.medicine_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Dosage</label>
                                                    <input type="text" name="medicines[0][dosage]" class="form-control @error('medicines.0.dosage') is-invalid @enderror" required>
                                                    @error('medicines.0.dosage')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Frequency</label>
                                                    <input type="text" name="medicines[0][frequency]" class="form-control @error('medicines.0.frequency') is-invalid @enderror" required>
                                                    @error('medicines.0.frequency')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Duration</label>
                                                    <input type="text" name="medicines[0][duration]" class="form-control @error('medicines.0.duration') is-invalid @enderror" required>
                                                    @error('medicines.0.duration')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Instructions</label>
                                                    <input type="text" name="medicines[0][instructions]" class="form-control @error('medicines.0.instructions') is-invalid @enderror">
                                                    @error('medicines.0.instructions')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-medicine">Add Medicine</button>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Tests</h6>
                            </div>
                            <div class="card-body">
                                <div id="tests-container">
                                    <div class="test-item mb-3">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label>Test</label>
                                                    <select name="tests[0][test_id]" class="form-control @error('tests.0.test_id') is-invalid @enderror">
                                                        <option value="">Select Test</option>
                                                        @foreach($tests as $test)
                                                            <option value="{{ $test->id }}">{{ $test->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('tests.0.test_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Instructions</label>
                                                    <input type="text" name="tests[0][instructions]" class="form-control @error('tests.0.instructions') is-invalid @enderror">
                                                    @error('tests.0.instructions')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-test">Add Test</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Prescription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let medicineCount = 1;
        let testCount = 1;

        document.getElementById('add-medicine').addEventListener('click', function() {
            const container = document.getElementById('medicines-container');
            const template = container.querySelector('.medicine-item').cloneNode(true);
            
            // Update indices
            template.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('[0]', `[${medicineCount}]`);
                input.value = '';
            });
            
            container.appendChild(template);
            medicineCount++;
        });

        document.getElementById('add-test').addEventListener('click', function() {
            const container = document.getElementById('tests-container');
            const template = container.querySelector('.test-item').cloneNode(true);
            
            // Update indices
            template.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('[0]', `[${testCount}]`);
                input.value = '';
            });
            
            container.appendChild(template);
            testCount++;
        });
    });
</script>
@endpush
@endsection 