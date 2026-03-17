<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Masuk {{ $order->order_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f6f7fb; color:#111827; }
        .wrap { max-width: 640px; margin: 28px auto; background:#fff; border:1px solid #e5e7eb; border-radius: 10px; overflow:hidden; }
        .hd { padding:18px 22px; background:#111827; color:#fff; }
        .hd b { font-family: monospace; }
        .bd { padding: 18px 22px; }
        .meta { font-size: 13px; color:#6b7280; margin-top: 6px; }
        .btn { display:inline-block; padding: 11px 16px; background:#ea580c; color:#fff !important; text-decoration:none; border-radius: 8px; font-weight: 700; }
        table { width:100%; border-collapse: collapse; margin-top: 14px; }
        th { text-align:left; font-size: 11px; color:#6b7280; text-transform: uppercase; letter-spacing:.4px; border-bottom:1px solid #e5e7eb; padding: 10px 0; }
        td { padding: 10px 0; border-bottom:1px solid #f3f4f6; font-size: 13px; }
        .r { text-align:right; }
        .ft { padding: 14px 22px; font-size: 12px; color:#9ca3af; background:#f9fafb; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hd">
        Order masuk dari customer: <b>{{ $order->order_code }}</b>
        <div class="meta">Status saat ini: {{ $order->status }}</div>
    </div>
    <div class="bd">
        <div style="font-size:14px; margin-bottom:10px;">
            Customer sudah memilih item layanan melalui halaman keranjang.
        </div>

        <div class="meta">
            Nama: <b>{{ $order->customer_name }}</b><br>
            Email: <b>{{ $order->customer_email ?: '-' }}</b>
        </div>

        <div style="margin-top:16px;">
            <a href="{{ $adminLink }}" class="btn">Buka Order di Admin</a>
        </div>

        @if($order->offer && $order->offer->details->count())
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th class="r">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->offer->details as $d)
                        <tr>
                            <td>{{ $d->package?->name ?? ('Package #' . $d->package_id) }}</td>
                            <td class="r">{{ $d->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="ft">
        Email ini otomatis dari sistem PUTP.
    </div>
</div>
</body>
</html>

