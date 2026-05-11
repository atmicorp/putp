<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('packages')
            ->orderBy('category_id')
            ->paginate(15);

        return view('category::index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_category' => 'required|string|max:255',
        ], [
            'nama_category.required' => 'Nama category wajib diisi.',
        ]);

        // Ambil angka urutan terakhir dari category_id yang ada
        $last = Category::orderByRaw("CAST(SUBSTRING(category_id, 5) AS UNSIGNED) DESC")
            ->value('category_id');

        // Ekstrak nomor urut, lalu increment
        $nextNumber = $last ? ((int) substr($last, 4)) + 1 : 1;

        $validated['category_id'] = 'CAT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Category::create($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category berhasil ditambahkan.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('packages');

        return view('category::show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category::edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_category' => 'required|string|max:255',
        ], [
            'nama_category.required' => 'Nama category wajib diisi.',
        ]);

        $category->update($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Optional: cek apakah masih ada package terkait
        if ($category->packages()->exists()) {
            return redirect()->route('category.index')
                ->with('error', 'Category tidak dapat dihapus karena masih memiliki package terkait.');
        }

        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category berhasil dihapus.');
    }
}