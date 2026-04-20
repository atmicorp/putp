<?php

namespace App\Http\Controllers;

use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['packages' => function ($query) {
            $query->where('is_active', true)
                ->with('blackoutDates')                          // ← tambahan
                ->select('id', 'category_id', 'name', 'description', 'base_price');
        }])->get();

        // Siapkan data untuk JS — proses di PHP, bukan di Blade
        $categoryJson = $categories->map(function ($c) {
            return [
                'category_id'   => $c->category_id,
                'nama_category' => $c->nama_category,
                'packages' => $c->packages->map(function ($p) {
                    // Eager-load sudah dilakukan di query, ambil date saja
                    $blackouts = $p->blackoutDates
                    ->map(fn($b) => $b->getRawOriginal('date')) // ambil langsung dari DB tanpa konversi
                    ->values()
                    ->toArray();

                    return [
                        'id'          => $p->id,
                        'nama'        => $p->name,
                        'deskripsi'   => $p->description,
                        'harga'       => $p->base_price,
                        'satuan'      => 'paket',
                        'gambar'      => $p->gambar ?? null,
                        'tags'        => [],
                        'specs'       => [],
                        'available'   => true,
                        'badge'       => null,
                        'blackouts'   => $blackouts,   // ← tambahan
                    ];
                })->values(),
            ];
        })->values()->toJson();

        return view('welcome', compact('categories', 'categoryJson'));
    }
}