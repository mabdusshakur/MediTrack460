<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Requisition;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PharmacistController extends Controller
{
    public function dashboard()
    {
        $pendingPrescriptions = Prescription::with(['patient', 'medicineItems.medicine'])
            ->whereHas('medicineItems', function ($query) {
                $query->where('status', 'pending');
            })
            ->count();
            
        $lowStockMedicines = Stock::where('quantity', '<', 10)
            ->where('status', 'active')
            ->count();
            
        $pendingRequisitions = Requisition::where('status', 'pending')->count();
        
        $prescriptions = Prescription::with(['patient', 'doctor', 'medicineItems.medicine'])
            ->whereHas('medicineItems', function ($query) {
                $query->where('status', 'pending');
            })
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.pharmacist', compact('pendingPrescriptions', 'lowStockMedicines', 'pendingRequisitions', 'prescriptions'));
    }

    public function prescriptions()
    {
        $prescriptions = Prescription::with(['patient', 'medicineItems.medicine'])
            ->whereHas('medicineItems', function ($query) {
                $query->where('status', 'pending');
            })
            ->latest()
            ->paginate(10);
            
        return view('pharmacist.prescriptions.index', compact('prescriptions'));
    }

    public function showPrescription(Prescription $prescription)
    {
        $prescription->load(['patient', 'medicineItems.medicine']);
        return view('pharmacist.prescriptions.show', compact('prescription'));
    }

    public function dispenseMedicine(Prescription $prescription, Request $request)
    {
        $validated = $request->validate([
            'medicine_items' => 'required|array',
            'medicine_items.*' => 'required|exists:medicine_items,id',
        ]);

        try {
            $result = DB::transaction(function () use ($prescription, $validated) {
                foreach ($validated['medicine_items'] as $itemId) {
                    $medicineItem = $prescription->medicineItems()->findOrFail($itemId);
                    
                    // Check stock
                    $stock = Stock::where('medicine_id', $medicineItem->medicine_id)
                        ->where('status', 'active')
                        ->first();
                        
                    if (!$stock || $stock->quantity < 1) {
                        return [
                            'success' => false,
                            'message' => "Insufficient stock for {$medicineItem->medicine->name}"
                        ];
                    }
                    
                    // Update stock
                    $stock->decrement('quantity');
                    
                    // Update medicine item status
                    $medicineItem->update(['status' => 'dispensed']);
                }

                return [
                    'success' => true,
                    'message' => 'Medicines dispensed successfully.'
                ];
            });

            if (!$result['success']) {
                return back()->withErrors([
                    'stock' => $result['message']
                ]);
            }

            return redirect()->route('pharmacist.prescriptions.show', $prescription)
                ->with('success', $result['message']);

        } catch (\Exception $e) {
            return back()->withErrors([
                'stock' => $e->getMessage()
            ]);
        }
    }

    public function requisitions()
    {
        $requisitions = Requisition::with(['medicine', 'requestedBy'])
            ->where('requested_by', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('pharmacist.requisitions.index', compact('requisitions'));
    }

    public function createRequisition()
    {
        $medicines = Medicine::where('status', 'active')->get();
        return view('pharmacist.requisitions.create', compact('medicines'));
    }

    public function storeRequisition(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $requisition = Requisition::create([
            'medicine_id' => $validated['medicine_id'],
            'requested_by' => Auth::id(),
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('pharmacist.requisitions.show', $requisition)
            ->with('success', 'Requisition created successfully.');
    }

    public function showRequisition(Requisition $requisition)
    {
        $requisition->load(['medicine', 'requestedBy', 'approvedBy']);
        return view('pharmacist.requisitions.show', compact('requisition'));
    }

    public function stock()
    {
        $stocks = Stock::with('medicine')
            ->where('status', 'active')
            ->orderBy('quantity')
            ->paginate(10);
            
        return view('pharmacist.stock.index', compact('stocks'));
    }
} 