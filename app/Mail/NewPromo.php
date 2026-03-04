<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Attachment;
use App\Models\Promo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPromo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Promo $promo,
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
            subject: 'Promo Baru: '.$this->promo->nama,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $promo = Promo::with('produk')->find($this->promo->id);

        return new Content(
            view: 'mail.new_promo',
            with: [
                'promo' => $promo,
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
