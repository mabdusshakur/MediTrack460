<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\LabTechnicianController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\StorekeeperController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    // Dashboard Routes
    Route::get('/', function () {
        $user = Auth::user();
        return match($user->role) {
            'admin' => app(AdminController::class)->dashboard(),
            'receptionist' => app(ReceptionistController::class)->dashboard(),
            'doctor' => app(DoctorController::class)->dashboard(),
            'pharmacist' => app(PharmacistController::class)->dashboard(),
            'storekeeper' => app(StorekeeperController::class)->dashboard(),
            'lab_technician' => app(LabTechnicianController::class)->dashboard(),
            default => abort(403, 'Unauthorized role.'),
        };
    })->name('dashboard');
    
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('medicines', MedicineController::class);
        Route::resource('tests', TestController::class);
        Route::get('logs', [AdminController::class, 'activityLogs'])->name('logs.index');
        Route::get('backup', [AdminController::class, 'backup'])->name('backup.index');
        Route::post('backup/create', [AdminController::class, 'createBackup'])->name('backup.create');
        Route::get('backup/download/{backup}', [AdminController::class, 'downloadBackup'])->name('backup.download');
        Route::post('backup/restore/{backup}', [AdminController::class, 'restoreBackup'])->name('backup.restore');
        Route::delete('backup/{backup}', [AdminController::class, 'destroyBackup'])->name('backup.destroy');
        Route::post('backup/settings', [AdminController::class, 'updateBackupSettings'])->name('backup.settings');
        Route::post('export', [AdminController::class, 'exportData'])->name('export');
    });

    // Receptionist Routes
    Route::middleware(['role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('patients/search', [ReceptionistController::class, 'searchPatients'])->name('patients.search');
        Route::resource('patients', PatientController::class);
        Route::get('tokens/create/{patient}', [TokenController::class, 'create'])->name('tokens.create');
        Route::post('tokens/{patient}', [TokenController::class, 'store'])->name('tokens.store');
        Route::get('tokens', [TokenController::class, 'index'])->name('tokens.index');
        Route::get('tokens/{token}', [TokenController::class, 'show'])->name('tokens.show');
        Route::get('tokens/{token}/edit', [TokenController::class, 'edit'])->name('tokens.edit');
        Route::put('tokens/{token}', [TokenController::class, 'update'])->name('tokens.update');
        Route::delete('tokens/{token}', [TokenController::class, 'destroy'])->name('tokens.destroy');
        
        // Prescription routes
        Route::get('prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    });

    // Doctor Routes
    Route::middleware(['role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('patients/today', [DoctorController::class, 'todayPatients'])->name('patients.today');
        Route::get('patients/{patient}/history', [DoctorController::class, 'patientHistory'])->name('patients.history');
        Route::get('prescriptions', [DoctorController::class, 'prescriptions'])->name('prescriptions.index');
        Route::get('prescriptions/{prescription}', [DoctorController::class, 'showPrescription'])->name('prescriptions.show');
        Route::get('prescriptions/create/{patient}/{token}', [DoctorController::class, 'createPrescription'])->name('prescriptions.create');
        Route::post('prescriptions/{patient}/{token}', [DoctorController::class, 'storePrescription'])->name('prescriptions.store');
    });

    // Pharmacist Routes
    Route::middleware(['role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
        Route::get('prescriptions', [PharmacistController::class, 'prescriptions'])->name('prescriptions.index');
        Route::get('prescriptions/{prescription}', [PharmacistController::class, 'showPrescription'])->name('prescriptions.show');
        Route::post('prescriptions/{prescription}/dispense', [PharmacistController::class, 'dispenseMedicine'])->name('prescriptions.dispense');
        
        // Requisition Routes
        Route::get('requisitions', [PharmacistController::class, 'requisitions'])->name('requisitions.index');
        Route::get('requisitions/create', [PharmacistController::class, 'createRequisition'])->name('requisitions.create');
        Route::post('requisitions', [PharmacistController::class, 'storeRequisition'])->name('requisitions.store');
        Route::get('requisitions/{requisition}', [PharmacistController::class, 'showRequisition'])->name('requisitions.show');
        
        Route::resource('stock', StockController::class);
    });

    // Storekeeper Routes
    Route::middleware(['auth', 'role:storekeeper'])->prefix('storekeeper')->name('storekeeper.')->group(function () {
        Route::get('/dashboard', [StorekeeperController::class, 'dashboard'])->name('dashboard');
        Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
        Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
        Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
        Route::get('/stock/{stock}', [StockController::class, 'show'])->name('stock.show');
        Route::get('/stock/{stock}/edit', [StockController::class, 'edit'])->name('stock.edit');
        Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
        Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
        Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
        
        // Requisition routes
        Route::get('/requisitions', [RequisitionController::class, 'index'])->name('requisitions.index');
        Route::get('/requisitions/create', [RequisitionController::class, 'create'])->name('requisitions.create');
        Route::post('/requisitions', [RequisitionController::class, 'store'])->name('requisitions.store');
        Route::get('/requisitions/{requisition}', [RequisitionController::class, 'show'])->name('requisitions.show');
        Route::post('/requisitions/{requisition}/approve', [RequisitionController::class, 'approve'])->name('requisitions.approve');
        Route::post('/requisitions/{requisition}/reject', [RequisitionController::class, 'reject'])->name('requisitions.reject');
        Route::delete('/requisitions/{requisition}', [RequisitionController::class, 'destroy'])->name('requisitions.destroy');
    });

    // Lab Technician Routes
    Route::middleware(['role:lab_technician'])->prefix('lab')->name('lab.')->group(function () {
        Route::get('tests/pending', [LabTechnicianController::class, 'pendingTests'])->name('tests.pending');
        Route::get('tests/completed', [LabTechnicianController::class, 'completedTests'])->name('tests.completed');
        Route::get('tests/{testItem}', [LabTechnicianController::class, 'showTest'])->name('tests.show');
        Route::resource('results', TestResultController::class);
        Route::get('results/{testResult}/download', [TestResultController::class, 'download'])->name('results.download');
    });
});
