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
        $link = route('orders.guest.show', [
            'slug'  => $this->order->customer_slug,
            'token' => $this->order->access_token,
        ]);

        return $this->subject('Penawaran Order ' . $this->order->order_code)
            ->view('order::emails.offer-link', [
                'order' => $this->order,
                'link'  => $link,
            ]);
    }
}