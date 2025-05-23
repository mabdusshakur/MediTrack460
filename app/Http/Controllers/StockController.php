<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('medicine')
            ->where('status', 'active')
            ->orderBy('quantity')
            ->paginate(10);
            
        return view('storekeeper.stock.index', compact('stocks'));
    }

    public function create()
    {
        $medicines = Medicine::where('status', 'active')->get();
        return view('storekeeper.stock.create', compact('medicines'));
    }

    public function store(Request $request)
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

    public function show(Stock $stock)
    {
        $stock->load('medicine');
        return view('storekeeper.stock.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $medicines = Medicine::where('status', 'active')->get();
        return view('storekeeper.stock.edit', compact('stock', 'medicines'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:0',
            'batch_number' => 'required|string|unique:stocks,batch_number,' . $stock->id,
            'expiry_date' => 'required|date',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $stock->update($validated);

        return redirect()->route('storekeeper.stock.show', $stock)
            ->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('storekeeper.stock.index')
            ->with('success', 'Stock deleted successfully.');
    }

    public function history()
    {
        $stocks = Stock::with('medicine')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('storekeeper.stock.history', compact('stocks'));
    }

    public function adjust(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'reason' => 'required|string',
        ]);

        DB::transaction(function () use ($validated, $stock) {
            $stock->update([
                'quantity' => $validated['quantity'],
            ]);

            // Log the adjustment
            activity()
                ->performedOn($stock)
                ->withProperties([
                    'old_quantity' => $stock->getOriginal('quantity'),
                    'new_quantity' => $validated['quantity'],
                    'reason' => $validated['reason'],
                ])
                ->log('Stock adjusted');
        });

        return redirect()->route('storekeeper.stock.show', $stock)
            ->with('success', 'Stock quantity adjusted successfully.');
    }
} 