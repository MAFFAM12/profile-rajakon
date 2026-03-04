<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Attachment;
use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShippedOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Pemesanan $shippedOrder
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Motech Store: Pesanan anda telah dikirim',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $order = Pemesanan::with('produk')->find($this->shippedOrder->id);
        $order->produk->harga = number_format($order->produk->harga, 0, ',', '.');
        $order->total = number_format($order->total, 0, ',', '.');

        return new Content(
            view: 'mail.shipped-order',
            with: [
                'order' => $order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
