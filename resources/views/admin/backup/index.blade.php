@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Backup Management</h6>
                    <form action="{{ route('admin.backup.create') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Backup
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <!-- Backup List -->
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Size</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $backup)
                                <tr>
                                    <td>{{ $backup->filename }}</td>
                                    <td>{{ number_format($backup->size / 1024 / 1024, 2) }} MB</td>
                                    <td>{{ $backup->created_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        @if($backup->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($backup->status === 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-warning">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.backup.download', $backup->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#restoreModal{{ $backup->id }}">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                            <form action="{{ route('admin.backup.destroy', $backup->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this backup?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal{{ $backup->id }}" tabindex="-1" aria-labelledby="restoreModalLabel{{ $backup->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="restoreModalLabel{{ $backup->id }}">Confirm Restore</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to restore from this backup? This will overwrite all current data.</p>
                                                        <p class="text-danger"><strong>Warning: This action cannot be undone!</strong></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.backup.restore', $backup->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning">Restore Backup</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No backups found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $backups->links() }}
                    </div>
                </div>
            </div>

            <!-- Backup Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Backup Settings</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.backup.settings') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="backup_frequency">Backup Frequency</label>
                                    <select class="form-select" id="backup_frequency" name="backup_frequency">
                                        <option value="daily" {{ $settings->backup_frequency === 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ $settings->backup_frequency === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ $settings->backup_frequency === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="retention_period">Retention Period (days)</label>
                                    <input type="number" class="form-control" id="retention_period" name="retention_period" value="{{ $settings->retention_period }}" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 