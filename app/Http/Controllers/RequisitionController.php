<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Medicine;
use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
{
    public function index()
    {
        $requisitions = Requisition::with(['medicine', 'requestedBy'])
            ->latest()
            ->paginate(10);
            
        return view('storekeeper.requisitions.index', compact('requisitions'));
    }

    public function create()
    {

    }

    public function store(Request $request)
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

        return redirect()->route('storekeeper.requisitions.show', $requisition)
            ->with('success', 'Requisition created successfully.');
    }

    public function show(Requisition $requisition)
    {
        $requisition->load(['medicine', 'requestedBy', 'approvedBy']);
        return view('storekeeper.requisitions.show', compact('requisition'));
    }

    public function approve(Requisition $requisition)
    {
        DB::transaction(function () use ($requisition) {
            // Update requisition status
            $requisition->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Add to stock
            $stock = Stock::where('medicine_id', $requisition->medicine_id)
                ->where('status', 'active')
                ->first();

            if ($stock) {
                $stock->increment('quantity', $requisition->quantity);
            } else {
                Stock::create([
                    'medicine_id' => $requisition->medicine_id,
                    'quantity' => $requisition->quantity,
                    'batch_number' => 'REQ-' . $requisition->id,
                    'expiry_date' => now()->addYear(),
                    'purchase_date' => now(),
                    'purchase_price' => 0,
                ]);
            }
        });

        return redirect()->route('storekeeper.requisitions.show', $requisition)
            ->with('success', 'Requisition approved and stock updated.');
    }

    public function reject(Request $request, Requisition $requisition)
    {
        $validated = $request->validate([
            'notes' => 'required|string',
        ]);

        $requisition->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('storekeeper.requisitions.show', $requisition)
            ->with('success', 'Requisition rejected.');
    }

    public function destroy(Requisition $requisition)
    {
        $requisition->delete();
        return redirect()->route('storekeeper.requisitions.index')
            ->with('success', 'Requisition deleted successfully.');
    }
} 