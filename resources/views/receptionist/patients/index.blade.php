@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Patients</h1>
        <a href="{{ route('receptionist.patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Patient
        </a>
    </div>

    <!-- Search Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Search Patients</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('receptionist.patients.search') }}" method="GET" class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="query" class="form-control" placeholder="Search by name, email or phone" value="{{ $query ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>

    <!-- Patients List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Patients List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->email }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->age }} years</td>
                                <td>{{ ucfirst($patient->gender) }}</td>
                                <td>{{ $patient->blood_group ?: 'Not specified' }}</td>
                                <td>
                                    <a href="{{ route('receptionist.patients.show', $patient) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('receptionist.tokens.create', $patient) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-ticket-alt"></i> Create Token
                                    </a>
                                    <a href="{{ route('receptionist.patients.edit', $patient) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('receptionist.patients.destroy', $patient) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 