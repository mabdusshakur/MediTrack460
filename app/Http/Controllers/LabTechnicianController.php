<?php

namespace App\Http\Controllers;

use App\Models\TestItem;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LabTechnicianController extends Controller
{
    public function dashboard()
    {
        $pendingTests = TestItem::where('status', 'pending')->count();
        $completedTests = TestItem::where('status', 'completed')->count();
        $todayTests = TestItem::whereDate('created_at', today())->count();
        
        return view('dashboard.lab_technician', compact('pendingTests', 'completedTests', 'todayTests'));
    }

    public function pendingTests()
    {
        $testItems = TestItem::with(['prescription.patient', 'test'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('lab.tests.pending', compact('testItems'));
    }

    public function completedTests()
    {
        $testItems = TestItem::with(['prescription.patient', 'test', 'testResult'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);
            
        return view('lab.tests.completed', compact('testItems'));
    }

    public function showTest(TestItem $testItem)
    {
        $testItem->load(['prescription.patient', 'test', 'testResult']);
        return view('lab.tests.show', compact('testItem'));
    }

    public function createResult(TestItem $testItem)
    {
        return view('lab.results.create', compact('testItem'));
    }

    public function storeResult(Request $request, TestItem $testItem)
    {
        $validated = $request->validate([
            'result' => 'required|string',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('result_file')) {
            $path = $request->file('result_file')->store('test-results');
            $validated['result_file'] = $path;
        }

        $result = TestResult::create([
            'test_item_id' => $testItem->id,
            'result' => $validated['result'],
            'result_file' => $validated['result_file'] ?? null,
            'notes' => $validated['notes'],
            'status' => 'completed',
            'performed_by' => Auth::id(),
            'performed_at' => now(),
        ]);

        $testItem->update(['status' => 'completed']);

        return redirect()->route('lab.tests.show', $testItem)
            ->with('success', 'Test result added successfully.');
    }

    public function editResult(TestItem $testItem)
    {
        $testItem->load('testResult');
        return view('lab.results.edit', compact('testItem'));
    }

    public function updateResult(Request $request, TestItem $testItem)
    {
        $validated = $request->validate([
            'result' => 'required|string',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('result_file')) {
            // Delete old file if exists
            if ($testItem->testResult && $testItem->testResult->result_file) {
                Storage::delete($testItem->testResult->result_file);
            }
            
            $path = $request->file('result_file')->store('test-results');
            $validated['result_file'] = $path;
        }

        $testItem->testResult->update([
            'result' => $validated['result'],
            'result_file' => $validated['result_file'] ?? $testItem->testResult->result_file,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('lab.tests.show', $testItem)
            ->with('success', 'Test result updated successfully.');
    }

    public function downloadResult(TestItem $testItem)
    {
        if (!$testItem->testResult || !$testItem->testResult->result_file) {
            return back()->with('error', 'No result file available.');
        }

        return Storage::download($testItem->testResult->result_file);
    }
} 