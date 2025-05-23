@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activity Logs</h6>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form action="{{ route('admin.logs.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user">User</label>
                                    <select class="form-select" id="user" name="user">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">Activity Type</label>
                                    <select class="form-select" id="type" name="type">
                                        <option value="">All Types</option>
                                        <option value="created" {{ request('type') == 'created' ? 'selected' : '' }}>Created</option>
                                        <option value="updated" {{ request('type') == 'updated' ? 'selected' : '' }}>Updated</option>
                                        <option value="deleted" {{ request('type') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Model</th>
                                    <th>Description</th>
                                    <th>Properties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('M d, Y H:i A') }}</td>
                                    <td>{{ $log->causer->name ?? 'System' }}</td>
                                    <td>
                                        @if($log->description === 'created')
                                            <span class="badge bg-success">Created</span>
                                        @elseif($log->description === 'updated')
                                            <span class="badge bg-warning">Updated</span>
                                        @elseif($log->description === 'deleted')
                                            <span class="badge bg-danger">Deleted</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($log->description) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ class_basename($log->subject_type) }}</td>
                                    <td>{{ $log->properties['description'] ?? '' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1" aria-labelledby="logModalLabel{{ $log->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="logModalLabel{{ $log->id }}">Log Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <pre class="bg-light p-3">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No activity logs found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 