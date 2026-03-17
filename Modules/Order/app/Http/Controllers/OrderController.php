<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Not implemented.',
        ], 501);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Not implemented.',
        ], 501);
    }

    public function show(Order $order)
    {
        return response()->json([
            'message' => 'Not implemented.',
        ], 501);
    }

    public function update(Request $request, Order $order)
    {
        return response()->json([
            'message' => 'Not implemented.',
        ], 501);
    }

    public function destroy(Order $order)
    {
        return response()->json([
            'message' => 'Not implemented.',
        ], 501);
    }
}

