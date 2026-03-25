<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statuses = $this->getStatuses();

        $countByStatus = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalOrders  = Order::count();
        $doneOrders   = $countByStatus[Order::STATUS_DONE]           ?? 0;
        $activeOrders = ($countByStatus[Order::STATUS_OFFERED]       ?? 0)
                      + ($countByStatus[Order::STATUS_APPROVED]      ?? 0)
                      + ($countByStatus[Order::STATUS_PROCESSING]    ?? 0)
                      + ($countByStatus[Order::STATUS_SUBMIT    ]    ?? 0);

        $newThisMonth = Order::whereMonth('created_at', now()->month)
                             ->whereYear('created_at',  now()->year)
                             ->count();

        $recentOrders = Order::with('creator')->latest()->take(8)->get();

        $monthlyData = $this->buildMonthlyData();

        return view('dashboard', [
            'statuses'      => $statuses,
            'countByStatus' => $countByStatus,
            'totalOrders'   => $totalOrders,
            'doneOrders'    => $doneOrders,
            'activeOrders'  => $activeOrders,
            'newThisMonth'  => $newThisMonth,
            'recentOrders'  => $recentOrders,
            'chartLabels'   => $monthlyData->pluck('label')->toJson(),
            'chartCounts'   => $monthlyData->pluck('count')->toJson(),
            'statusLabels'  => collect($statuses)->pluck('label')->values()->toJson(),
            'statusColors'  => collect($statuses)->pluck('color')->values()->toJson(),
            'statusCounts'  => collect($statuses)->keys()
                                    ->map(fn($s) => $countByStatus[$s] ?? 0)
                                    ->values()->toJson(),
        ]);
    }

    /**
     * AJAX endpoint: returns filtered chart data + status counts.
     * Query params:
     *   filter_type : 'month' | 'week' | 'range'
     *   month       : 'YYYY-MM'  (when filter_type=month)
     *   week        : 'YYYY-WW'  (when filter_type=week, ISO week)
     *   date_from   : 'YYYY-MM-DD' (when filter_type=range)
     *   date_to     : 'YYYY-MM-DD' (when filter_type=range)
     */
    public function filterData(Request $request)
    {
        $type = $request->input('filter_type', 'default');

        [$startDate, $endDate, $chartData] = match ($type) {
            'month' => $this->resolveMonthFilter($request),
            'week'  => $this->resolveWeekFilter($request),
            'range' => $this->resolveRangeFilter($request),
            default => [null, null, $this->buildMonthlyData()],
        };

        $statuses      = $this->getStatuses();
        $countByStatus = $this->countByStatusInRange($startDate, $endDate);

        $statusData = collect($statuses)->map(function ($s, $key) use ($countByStatus) {
            return [
                'key'   => $key,
                'label' => $s['label'],
                'color' => $s['color'],
                'count' => $countByStatus[$key] ?? 0,
            ];
        })->values();

        $total = Order::when($startDate, fn($q) => $q->whereBetween('created_at', [$startDate, $endDate]))->count();

        return response()->json([
            'chart' => [
                'labels' => $chartData->pluck('label'),
                'counts' => $chartData->pluck('count'),
            ],
            'statuses'    => $statusData,
            'totalOrders' => $total,
        ]);
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function getStatuses(): array
    {
        return [
            Order::STATUS_DRAFT         => ['label' => 'Draft',         'color' => '#9ca3af', 'cls' => 's-draft'],
            Order::STATUS_SUBMIT        => ['label' => 'Submit',        'color' => '#d97706', 'cls' => 's-submit'],
            Order::STATUS_OFFERED       => ['label' => 'Offered',       'color' => '#2563eb', 'cls' => 's-offered'],
            Order::STATUS_REJECTED      => ['label' => 'Rejected',      'color' => '#dc2626', 'cls' => 's-rejected'],
            Order::STATUS_APPROVED      => ['label' => 'Approved',      'color' => '#059669', 'cls' => 's-approved'],
            Order::STATUS_PROCESSING    => ['label' => 'Processing',    'color' => '#7c3aed', 'cls' => 's-processing'],
            Order::STATUS_DONE          => ['label' => 'Done',          'color' => '#16a34a', 'cls' => 's-done'],
        ];
    }

    /** Default: 6 bulan terakhir, tiap titik = 1 bulan */
    private function buildMonthlyData()
    {
        return collect(range(5, 0))->map(function ($i) {
            $date  = now()->subMonths($i);
            $count = Order::whereYear('created_at',  $date->year)
                          ->whereMonth('created_at', $date->month)
                          ->count();
            return ['label' => $date->format('M Y'), 'count' => $count];
        });
    }

    /** Filter: bulan tertentu → tiap titik = 1 hari */
    private function resolveMonthFilter(Request $request): array
    {
        $month     = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate   = $startDate->copy()->endOfMonth();

        $chartData = collect();
        $cursor    = $startDate->copy();
        while ($cursor->lte($endDate)) {
            $day   = $cursor->copy();
            $count = Order::whereDate('created_at', $day)->count();
            $chartData->push(['label' => $day->format('d'), 'count' => $count]);
            $cursor->addDay();
        }

        return [$startDate, $endDate, $chartData];
    }

    /** Filter: minggu tertentu → tiap titik = 1 hari (Sen–Min) */
    private function resolveWeekFilter(Request $request): array
    {
        $week  = $request->input('week'); // format: YYYY-WW
        if ($week && preg_match('/^(\d{4})-(\d{2})$/', $week, $m)) {
            $startDate = Carbon::now()->setISODate((int)$m[1], (int)$m[2])->startOfWeek();
        } else {
            $startDate = now()->startOfWeek();
        }
        $endDate = $startDate->copy()->endOfWeek();

        $chartData = collect();
        $cursor    = $startDate->copy();
        while ($cursor->lte($endDate)) {
            $day   = $cursor->copy();
            $count = Order::whereDate('created_at', $day)->count();
            $chartData->push(['label' => $day->format('D, d M'), 'count' => $count]);
            $cursor->addDay();
        }

        return [$startDate, $endDate, $chartData];
    }

    /** Filter: range tanggal bebas → tiap titik = 1 hari (jika ≤31 hari) atau 1 minggu */
    private function resolveRangeFilter(Request $request): array
    {
        $startDate = Carbon::parse($request->input('date_from', now()->subDays(29)->format('Y-m-d')))->startOfDay();
        $endDate   = Carbon::parse($request->input('date_to',   now()->format('Y-m-d')))->endOfDay();

        $diffDays  = $startDate->diffInDays($endDate);

        $chartData = collect();

        if ($diffDays <= 31) {
            // Harian
            $cursor = $startDate->copy();
            while ($cursor->lte($endDate)) {
                $day   = $cursor->copy();
                $count = Order::whereDate('created_at', $day)->count();
                $chartData->push(['label' => $day->format('d M'), 'count' => $count]);
                $cursor->addDay();
            }
        } elseif ($diffDays <= 90) {
            // Mingguan
            $cursor = $startDate->copy()->startOfWeek();
            while ($cursor->lte($endDate)) {
                $weekStart = $cursor->copy();
                $weekEnd   = $cursor->copy()->endOfWeek()->min($endDate);
                $count     = Order::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                $chartData->push(['label' => $weekStart->format('d M'), 'count' => $count]);
                $cursor->addWeek();
            }
        } else {
            // Bulanan
            $cursor = $startDate->copy()->startOfMonth();
            while ($cursor->lte($endDate)) {
                $monthStart = $cursor->copy()->startOfMonth()->max($startDate);
                $monthEnd   = $cursor->copy()->endOfMonth()->min($endDate);
                $count      = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
                $chartData->push(['label' => $cursor->format('M Y'), 'count' => $count]);
                $cursor->addMonth();
            }
        }

        return [$startDate, $endDate, $chartData];
    }

    private function countByStatusInRange(?Carbon $from, ?Carbon $to): \Illuminate\Support\Collection
    {
        return Order::selectRaw('status, count(*) as total')
            ->when($from, fn($q) => $q->whereBetween('created_at', [$from, $to]))
            ->groupBy('status')
            ->pluck('total', 'status');
    }
}