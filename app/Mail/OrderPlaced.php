<?php

namespace App\Mail;

use App\Models\Order; // Pastikan untuk import Order model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    // [00:02:09] Buat properti publik untuk menampung data pesanan
    public $order;

    /**
     * Create a new message instance.
     */
    // [00:02:09] Terima order melalui constructor
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    // [00:02:29] Atur subjek email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed - DCodeMania',
        );
    }

    /**
     * Get the message content definition.
     */
    // [00:02:41]
    public function content(): Content
    {
        // [00:03:18] Buat URL untuk tombol "View Order"
        // Pastikan route 'my-orders.show' sudah didefinisikan di web.php
        $url = route('my-orders.show', $this->order);

        return new Content(
            markdown: 'mail.orders.placed',
            // [00:03:26] Kirim data order dan URL ke view
            with: [
                'order' => $this->order,
                'url' => $url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
