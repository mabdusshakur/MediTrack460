<aside class="sidebar">
    <div class="sidebar-header">
        <h5 class="text-white mb-0">MediTrack460</h5>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </li>

        @if(auth()->user()->role === 'receptionist')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('receptionist.patients.*') ? 'active' : '' }}" href="{{ route('receptionist.patients.index') }}">
                    <i class="fas fa-users me-2"></i>
                    Patients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('receptionist.tokens.*') ? 'active' : '' }}" href="{{ route('receptionist.tokens.index') }}">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Tokens
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'doctor')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('doctor.patients.*') ? 'active' : '' }}" href="{{ route('doctor.patients.today') }}">
                    <i class="fas fa-user-injured me-2"></i>
                    Today's Patients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('doctor.prescriptions.*') ? 'active' : '' }}" href="{{ route('doctor.prescriptions.index') }}">
                    <i class="fas fa-prescription me-2"></i>
                    Prescriptions
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'pharmacist')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pharmacist.prescriptions.*') ? 'active' : '' }}" href="{{ route('pharmacist.prescriptions.index') }}">
                    <i class="fas fa-prescription-bottle-alt me-2"></i>
                    Prescriptions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pharmacist.requisitions.*') ? 'active' : '' }}" href="{{ route('pharmacist.requisitions.index') }}">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Requisitions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pharmacist.stock.*') ? 'active' : '' }}" href="{{ route('pharmacist.stock.index') }}">
                    <i class="fas fa-boxes me-2"></i>
                    Stock
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'storekeeper')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('storekeeper.stock.*') ? 'active' : '' }}" href="{{ route('storekeeper.stock.index') }}">
                    <i class="fas fa-boxes me-2"></i>
                    Stock
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('storekeeper.requisitions.*') ? 'active' : '' }}" href="{{ route('storekeeper.requisitions.index') }}">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Requisitions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('storekeeper.stock.history') ? 'active' : '' }}" href="{{ route('storekeeper.stock.history') }}">
                    <i class="fas fa-history me-2"></i>
                    Stock History
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'lab_technician')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('lab.tests.pending') ? 'active' : '' }}" href="{{ route('lab.tests.pending') }}">
                    <i class="fas fa-vial me-2"></i>
                    Pending Tests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('lab.tests.completed') ? 'active' : '' }}" href="{{ route('lab.tests.completed') }}">
                    <i class="fas fa-check-circle me-2"></i>
                    Completed Tests
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users-cog me-2"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.medicines.*') ? 'active' : '' }}" href="{{ route('admin.medicines.index') }}">
                    <i class="fas fa-pills me-2"></i>
                    Medicines
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}" href="{{ route('admin.tests.index') }}">
                    <i class="fas fa-vial me-2"></i>
                    Tests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}">
                    <i class="fas fa-history me-2"></i>
                    Activity Logs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}" href="{{ route('admin.backup.index') }}">
                    <i class="fas fa-database me-2"></i>
                    Backup
                </a>
            </li>
        @endif
    </ul>
</aside> 