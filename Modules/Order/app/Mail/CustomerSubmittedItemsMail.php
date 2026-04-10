<?php

namespace Modules\Order\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSubmittedItemsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function build()
    {
        $this->order->load(['company', 'contact', 'creator', 'offer.details.package']);

        $order = $this->order;

        $adminLink = route('admin.orders.show', $order);

        return $this->subject('Order Masuk: ' . $order->order_code)
            ->view('order::emails.customer-submitted-items', compact('order', 'adminLink'));
    }
}

