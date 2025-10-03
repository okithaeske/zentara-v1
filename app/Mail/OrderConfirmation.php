<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing(['items.product']);
    }

    public function build(): self
    {
        $subject = sprintf('Thanks for your order - %s', config('app.name'));

        return $this->subject($subject)
            ->view('emails.order-confirmation')
            ->with([
                'order' => $this->order,
            ]);
    }
}
