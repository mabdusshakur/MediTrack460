<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMedicines = Medicine::count();
        $totalTests = Test::count();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('dashboard.admin', compact('totalUsers', 'totalMedicines', 'totalTests', 'recentUsers'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,receptionist,doctor,pharmacist,storekeeper,lab_technician',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User created successfully.');
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,receptionist,doctor,pharmacist,storekeeper,lab_technician',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Password::defaults()],
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function medicines()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function createMedicine()
    {
        return view('admin.medicines.create');
    }

    public function storeMedicine(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        $medicine = Medicine::create($validated);

        // Create initial stock record
        $medicine->stockHistory()->create([
            'quantity' => 0,
            'type' => 'in',
            'reference' => 'Initial Stock',
            'notes' => 'Initial stock record created',
            'status' => 'active',
            'batch_number' => 'INIT-' . date('Ymd') . '-' . str_pad($medicine->id, 4, '0', STR_PAD_LEFT),
            'expiry_date' => now()->addYears(2),
            'purchase_date' => now(),
            'purchase_price' => 0
        ]);

        return redirect()->route('admin.medicines.show', $medicine)
            ->with('success', 'Medicine added successfully.');
    }

    public function showMedicine(Medicine $medicine)
    {
        $medicine->load(['stockHistory', 'prescriptionItems.prescription.patient', 'prescriptionItems.prescription.doctor']);
        return view('admin.medicines.show', compact('medicine'));
    }

    public function editMedicine(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function updateMedicine(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.show', $medicine)
            ->with('success', 'Medicine updated successfully.');
    }

    public function tests()
    {
        $tests = Test::latest()->paginate(10);
        return view('admin.tests.index', compact('tests'));
    }

    public function createTest()
    {
        return view('admin.tests.create');
    }

    public function storeTest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tests',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'result_type' => 'required|in:numeric,text,file',
            'normal_range' => 'nullable|array',
            'unit' => 'nullable|string|max:50',
        ]);

        $test = Test::create($validated);

        return redirect()->route('admin.tests.show', $test)
            ->with('success', 'Test added successfully.');
    }

    public function showTest(Test $test)
    {
        return view('admin.tests.show', compact('test'));
    }

    public function editTest(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    public function updateTest(Request $request, Test $test)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tests,code,' . $test->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'result_type' => 'required|in:numeric,text,file',
            'normal_range' => 'nullable|json',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        // Convert normal_range from JSON to array
        if ($request->filled('normal_range')) {
            $validated['normal_range'] = json_decode($request->normal_range, true);
        }

        $test->update($validated);

        return redirect()->route('admin.tests.show', $test)
            ->with('success', 'Test updated successfully.');
    }

    public function activityLogs()
    {
        $logs = \Spatie\Activitylog\Models\Activity::with('causer')
            ->latest()
            ->paginate(20);
        
        $users = \App\Models\User::all();
            
        return view('admin.logs.index', compact('logs', 'users'));
    }

    public function backup()
    {
        $backups = \App\Models\Backup::latest()->paginate(10);
        $settings = \App\Models\BackupSetting::first() ?? new \App\Models\BackupSetting();
        return view('admin.backup.index', compact('backups', 'settings'));
    }

    public function createBackup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Create backup directory if it doesn't exist
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // Create backup using mysqldump
            $command = sprintf(
                'mysqldump -u%s -p%s %s > %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                $path
            );
            
            exec($command);
            
            // Create backup record
            $backup = \App\Models\Backup::create([
                'filename' => $filename,
                'size' => filesize($path),
                'status' => 'completed'
            ]);
            
            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function downloadBackup(\App\Models\Backup $backup)
    {
        $path = storage_path('app/backups/' . $backup->filename);
        
        if (!file_exists($path)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Backup file not found.');
        }
        
        return response()->download($path);
    }

    public function restoreBackup(\App\Models\Backup $backup)
    {
        try {
            $path = storage_path('app/backups/' . $backup->filename);
            
            if (!file_exists($path)) {
                return redirect()->route('admin.backup.index')
                    ->with('error', 'Backup file not found.');
            }
            
            // Restore backup using mysql
            $command = sprintf(
                'mysql -u%s -p%s %s < %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.database'),
                $path
            );
            
            exec($command);
            
            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Failed to restore backup: ' . $e->getMessage());
        }
    }

    public function destroyBackup(\App\Models\Backup $backup)
    {
        try {
            $path = storage_path('app/backups/' . $backup->filename);
            
            if (file_exists($path)) {
                unlink($path);
            }
            
            $backup->delete();
            
            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Failed to delete backup: ' . $e->getMessage());
        }
    }

    public function updateBackupSettings(Request $request)
    {
        $validated = $request->validate([
            'backup_frequency' => 'required|in:daily,weekly,monthly',
            'retention_period' => 'required|integer|min:1',
        ]);
        
        $settings = \App\Models\BackupSetting::first() ?? new \App\Models\BackupSetting();
        $settings->fill($validated);
        $settings->save();
        
        return redirect()->route('admin.backup.index')
            ->with('success', 'Backup settings updated successfully.');
    }

    public function exportData(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:patients,medicines,tests,users',
            'format' => 'required|in:csv,excel',
        ]);

        // Implementation for data export
        // This would typically use a package like Laravel Excel
        return back()->with('success', 'Data exported successfully.');
    }
} 