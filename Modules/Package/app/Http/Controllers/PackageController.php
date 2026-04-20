<?php

namespace Modules\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Machine;
use App\Models\Operator;
use App\Models\Package;
use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::with(['machine', 'picOperator', 'category']);
    
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('machine', fn($m) => $m->where('name', 'like', "%{$search}%"));
            });
        }
    
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
    
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        if ($request->filled('machine_id')) {
            $query->where('machine_id', $request->machine_id);
        }
    
        $packages  = $query->latest()->paginate(10)->withQueryString();
        $machines  = Machine::where('is_active', true)->orderBy('name')->get();
        $categories = Category::orderBy('category_id')->get();
    
        return view('package::index', compact('packages', 'machines', 'categories'));
    }

    public function create()
    {
        $machines  = Machine::where('is_active', true)->orderBy('name')->get();
        $operators = Operator::all()->sortBy(fn($o) => $o->getAttributes()[array_key_first($o->getAttributes())]);

        return view('package::create', compact('machines', 'operators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'machine_id'      => 'required|exists:machines,id',
            'pic_operator_id' => 'nullable|exists:operators,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string|max:2000',
            'base_price'      => 'required|numeric|min:0',
            'is_active'       => 'boolean',
            'blackout_dates'  => 'nullable|string', // comma-separated dari JS
        ]);

        $package = Package::create(collect($validated)->except('blackout_dates')->toArray());
        $this->syncBlackoutDates($package, $request->blackout_dates);

        return redirect()->route('package.index')
            ->with('success', 'Package berhasil ditambahkan.');
    }

    public function show(Package $package)
    {
        $package->load(['machine', 'picOperator', 'offerDetails']);

        return view('package::show', compact('package'));
    }

    public function edit(Package $package)
    {
        $machines  = Machine::where('is_active', true)->orderBy('name')->get();
        $operators = Operator::all()->sortBy(fn($o) => $o->getAttributes()[array_key_first($o->getAttributes())]);

        return view('package::edit', compact('package', 'machines', 'operators'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'machine_id'      => 'required|exists:machines,id',
            'pic_operator_id' => 'nullable|exists:operators,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string|max:2000',
            'base_price'      => 'required|numeric|min:0',
            'is_active'       => 'boolean',
            'blackout_dates'  => 'nullable|string',
        ]);

        $package->update(collect($validated)->except('blackout_dates')->toArray());
        $this->syncBlackoutDates($package, $request->blackout_dates);

        return redirect()->route('package.index')
            ->with('success', 'Package berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('package.index')
            ->with('success', 'Package berhasil dihapus.');
    }

    private function syncBlackoutDates(Package $package, ?string $rawDates): void
    {
        $dates = collect(
            array_filter(
                array_map('trim', explode(',', $rawDates ?? ''))
            )
        )->unique()->values();

        // Hapus semua yang tidak ada di list baru
        $package->blackoutDates()
            ->whereNotIn('date', $dates)
            ->delete();

        // Insert yang belum ada (ignore duplicate karena unique constraint)
        foreach ($dates as $date) {
            $package->blackoutDates()->firstOrCreate(['date' => $date]);
        }
    }
}