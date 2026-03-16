<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statuses = [
            Order::STATUS_DRAFT         => ['label' => 'Draft',         'color' => '#9ca3af', 'cls' => 's-draft'],
            Order::STATUS_OFFERED       => ['label' => 'Offered',       'color' => '#2563eb', 'cls' => 's-offered'],
            Order::STATUS_REJECTED      => ['label' => 'Rejected',      'color' => '#dc2626', 'cls' => 's-rejected'],
            Order::STATUS_FORM_REQUIRED => ['label' => 'Form Required', 'color' => '#d97706', 'cls' => 's-form_required'],
            Order::STATUS_APPROVED      => ['label' => 'Approved',      'color' => '#059669', 'cls' => 's-approved'],
            Order::STATUS_PROCESSING    => ['label' => 'Processing',    'color' => '#7c3aed', 'cls' => 's-processing'],
            Order::STATUS_DONE          => ['label' => 'Done',          'color' => '#16a34a', 'cls' => 's-done'],
        ];

        $countByStatus = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalOrders  = Order::count();
        $doneOrders   = $countByStatus[Order::STATUS_DONE]           ?? 0;
        $activeOrders = ($countByStatus[Order::STATUS_OFFERED]       ?? 0)
                      + ($countByStatus[Order::STATUS_APPROVED]      ?? 0)
                      + ($countByStatus[Order::STATUS_PROCESSING]    ?? 0)
                      + ($countByStatus[Order::STATUS_FORM_REQUIRED] ?? 0);

        $newThisMonth = Order::whereMonth('created_at', now()->month)
                             ->whereYear('created_at',  now()->year)
                             ->count();

        $recentOrders = Order::with('creator')->latest()->take(8)->get();

        $monthlyData = collect(range(5, 0))->map(function ($i) {
            $date  = now()->subMonths($i);
            $count = Order::whereYear('created_at',  $date->year)
                          ->whereMonth('created_at', $date->month)
                          ->count();
            return ['month' => $date->format('M'), 'count' => $count];
        });

        return view('dashboard', [
            'statuses'      => $statuses,
            'countByStatus' => $countByStatus,
            'totalOrders'   => $totalOrders,
            'doneOrders'    => $doneOrders,
            'activeOrders'  => $activeOrders,
            'newThisMonth'  => $newThisMonth,
            'recentOrders'  => $recentOrders,
            'chartLabels'   => $monthlyData->pluck('month')->toJson(),
            'chartCounts'   => $monthlyData->pluck('count')->toJson(),
            'statusLabels'  => collect($statuses)->pluck('label')->values()->toJson(),
            'statusColors'  => collect($statuses)->pluck('color')->values()->toJson(),
            'statusCounts'  => collect($statuses)->keys()
                                    ->map(fn($s) => $countByStatus[$s] ?? 0)
                                    ->values()->toJson(),
        ]);
    }
}