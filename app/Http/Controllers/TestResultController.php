<?php

namespace App\Http\Controllers;

use App\Models\TestItem;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestResultController extends Controller
{
    public function index()
    {
        $testResults = TestResult::with(['testItem.prescription.patient', 'testItem.test'])
            ->latest()
            ->paginate(10);
            
        return view('lab.results.index', compact('testResults'));
    }

    public function create(TestItem $testItem)
    {
        return view('lab.results.create', compact('testItem'));
    }

    public function store(Request $request, TestItem $testItem)
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

        return redirect()->route('lab.results.show', $result)
            ->with('success', 'Test result added successfully.');
    }

    public function show(TestResult $testResult)
    {
        $testResult->load(['testItem.prescription.patient', 'testItem.test']);
        return view('lab.results.show', compact('testResult'));
    }

    public function edit(TestResult $testResult)
    {
        return view('lab.results.edit', compact('testResult'));
    }

    public function update(Request $request, TestResult $testResult)
    {
        $validated = $request->validate([
            'result' => 'required|string',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('result_file')) {
            // Delete old file if exists
            if ($testResult->result_file) {
                Storage::delete($testResult->result_file);
            }
            
            $path = $request->file('result_file')->store('test-results');
            $validated['result_file'] = $path;
        }

        $testResult->update([
            'result' => $validated['result'],
            'result_file' => $validated['result_file'] ?? $testResult->result_file,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('lab.results.show', $testResult)
            ->with('success', 'Test result updated successfully.');
    }

    public function destroy(TestResult $testResult)
    {
        if ($testResult->result_file) {
            Storage::delete($testResult->result_file);
        }

        $testResult->delete();
        return redirect()->route('lab.results.index')
            ->with('success', 'Test result deleted successfully.');
    }

    public function download(TestResult $testResult)
    {
        if (!$testResult->result_file) {
            return back()->with('error', 'No result file available.');
        }

        return Storage::download($testResult->result_file);
    }
} 