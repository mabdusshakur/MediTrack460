<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
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

    public function show(Medicine $medicine)
    {
        $medicine->load(['stockHistory', 'medicineItems.prescription.patient', 'medicineItems.prescription.doctor']);
        return view('admin.medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
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

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
} 