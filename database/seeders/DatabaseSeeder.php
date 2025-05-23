<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medicine;
use App\Models\Test;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // Create receptionist user
        User::create([
            'name' => 'Receptionist User',
            'email' => 'receptionist@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_RECEPTIONIST,
        ]);

        // Create doctor user
        User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOCTOR,
        ]);

        // Create pharmacist user
        User::create([
            'name' => 'Pharmacist User',
            'email' => 'pharmacist@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PHARMACIST,
        ]);

        // Create storekeeper user
        User::create([
            'name' => 'Storekeeper User',
            'email' => 'storekeeper@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STOREKEEPER,
        ]);

        // Create lab technician user
        User::create([
            'name' => 'Lab Technician User',
            'email' => 'lab@meditrack.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_LAB_TECHNICIAN,
        ]);

        // Create sample medicines
        $medicines = [
            [
                'name' => 'Paracetamol 500mg',
                'generic_name' => 'Paracetamol',
                'category' => 'Pain Relief',
                'manufacturer' => 'ABC Pharma',
                'description' => 'For fever and pain relief',
                'unit' => 'Tablet',
                'price' => 5.00,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'generic_name' => 'Amoxicillin',
                'category' => 'Antibiotic',
                'manufacturer' => 'XYZ Pharma',
                'description' => 'For bacterial infections',
                'unit' => 'Capsule',
                'price' => 15.00,
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }

        // Create sample tests
        $tests = [
            [
                'name' => 'Complete Blood Count',
                'code' => 'CBC',
                'category' => 'Hematology',
                'description' => 'Measures different components of blood',
                'price' => 500.00,
                'result_type' => 'numeric',
                'normal_range' => ['min' => 0, 'max' => 100],
                'unit' => 'cells/µL',
            ],
            [
                'name' => 'Blood Glucose',
                'code' => 'BG',
                'category' => 'Biochemistry',
                'description' => 'Measures blood sugar levels',
                'price' => 300.00,
                'result_type' => 'numeric',
                'normal_range' => ['min' => 70, 'max' => 140],
                'unit' => 'mg/dL',
            ],
        ];

        foreach ($tests as $test) {
            Test::create($test);
        }
    }
}
