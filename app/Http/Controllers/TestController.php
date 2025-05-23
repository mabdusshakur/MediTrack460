<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::latest()->paginate(10);
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.tests.create');
    }

    public function store(Request $request)
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

    public function show(Test $test)
    {
        return view('admin.tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tests,code,' . $test->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'result_type' => 'required|in:numeric,text,file',
            'normal_range' => 'nullable|array',
            'unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $test->update($validated);

        return redirect()->route('admin.tests.show', $test)
            ->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')
            ->with('success', 'Test deleted successfully.');
    }
} 