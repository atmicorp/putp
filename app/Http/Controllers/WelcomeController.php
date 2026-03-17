<?php

namespace App\Http\Controllers;

use App\Models\Category;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['packages' => function ($query) {
            $query->where('is_active', true)
                  ->select('id', 'category_id', 'name', 'description', 'base_price');
        }])->get();

        // Siapkan data untuk JS — proses di PHP, bukan di Blade
        $categoryJson = $categories->map(function ($c) {
            return [
                'category_id' => $c->category_id,
                'nama'        => $c->nama_category,
                'packages'    => $c->packages->map(function ($p) {
                    return [
                        'id'          => $p->id,
                        'name'        => $p->name,
                        'description' => $p->description,
                        'base_price'  => $p->base_price,
                    ];
                })->values(),
            ];
        })->values()->toJson();

        return view('welcome', compact('categories', 'categoryJson'));
    }
}