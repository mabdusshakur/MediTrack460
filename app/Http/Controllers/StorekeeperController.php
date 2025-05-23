<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Requisition;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StorekeeperController extends Controller
{
    public function dashboard()
    {
        // Get counts for statistics
        $lowStockItems = Stock::where('quantity', '<', 10)
            ->where('status', 'active')
            ->count();
        $pendingRequisitions = Requisition::where('status', 'pending')->count();
        $totalStockItems = Stock::where('status', 'active')->count();

        // Get low stock items list
        $lowStockItemsList = Stock::with('medicine')
            ->where('quantity', '<', 10)
            ->where('status', 'active')
            ->get()
            ->map(function ($stock) {
                return (object)[
                    'id' => $stock->id,
                    'name' => $stock->medicine->name,
                    'category' => $stock->medicine->category,
                    'current_stock' => $stock->quantity,
                    'minimum_stock' => 10
                ];
            });

        // Get pending requisitions
        $requisitions = Requisition::with(['medicine', 'requestedBy'])
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('dashboard.storekeeper', compact(
            'lowStockItems',
            'pendingRequisitions',
            'totalStockItems',
            'lowStockItemsList',
            'requisitions'
        ));
    }

    public function stock()
    {
        $stocks = Stock::with('medicine')
            ->where('status', 'active')
            ->orderBy('quantity')
            ->paginate(10);
            
        return view('storekeeper.stock.index', compact('stocks'));
    }

    public function createStock()
    {
        $medicines = Medicine::where('status', 'active')->get();
        return view('storekeeper.stock.create', compact('medicines'));
    }

    public function storeStock(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'required|string|unique:stocks',
            'expiry_date' => 'required|date|after:today',
            'purchase_date' => 'required|date|before_or_equal:today',
            'purchase_price' => 'required|numeric|min:0',
        ]);

        $stock = Stock::create($validated);

        return redirect()->route('storekeeper.stock.show', $stock)
            ->with('success', 'Stock added successfully.');
    }

    public function showStock(Stock $stock)
    {
        $stock->load('medicine');
        return view('storekeeper.stock.show', compact('stock'));
    }

    public function requisitions()
    {
        $requisitions = Requisition::with(['medicine', 'requestedBy'])
            ->latest()
            ->paginate(10);
            
        return view('storekeeper.requisitions.index', compact('requisitions'));
    }

    public function showRequisition(Requisition $requisition)
    {
        $requisition->load(['medicine', 'requestedBy', 'approvedBy']);
        return view('storekeeper.requisitions.show', compact('requisition'));
    }

    public function approveRequisition(Requisition $requisition)
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

    public function rejectRequisition(Requisition $requisition, Request $request)
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

    public function stockHistory()
    {
        $stocks = Stock::with('medicine')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('storekeeper.stock.history', compact('stocks'));
    }
} 