<?php

namespace Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function build()
    {
        // Load ulang di sini agar tidak bergantung pada eager load dari controller,
        // karena SerializesModels akan me-resolve ulang model dari database.
        $this->order->loadMissing(['offer.details.package']);

        $order   = $this->order;
        $offer   = $order->offer;
        $details = $offer->details;

        $link = route('orders.guest.show', [
            'slug'  => $order->company->slug,
            'token' => $order->access_token,
        ]);

        return $this->subject('Penawaran Order ' . $order->order_code)
            ->view('order::emails.offer-link', compact(
                'order',
                'offer',
                'details',
                'link',
            ));
    }
}