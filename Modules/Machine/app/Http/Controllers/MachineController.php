<?php

namespace Modules\Machine\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Machine::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $machines = $query->latest()->paginate(10);

        return view('machine::index', compact('machines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('machine::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:100|unique:machines,code',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
        ]);

        Machine::create($validated);

        return redirect()->route('machine.index')
            ->with('success', 'Machine created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Machine $machine)
    {
        $machine->load(['operators', 'packages']);

        return view('machine::show', compact('machine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        return view('machine::edit', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => ['required', 'string', 'max:100', Rule::unique('machines', 'code')->ignore($machine->id)],
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
        ]);

        $machine->update($validated);

        return redirect()->route('machine.index')
            ->with('success', 'Machine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('machine.index')
            ->with('success', 'Machine deleted successfully.');
    }
}