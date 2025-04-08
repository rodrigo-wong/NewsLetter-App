<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rows;
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     *
     * @param array  $rows
     * @param string $unsubscribeUrl
     */
    public function __construct(array $rows, string $unsubscribeUrl)
    {
        $this->rows = $rows;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                'cryptocurrency@gmai.com',
                'Cryptocurrency Newsletter'
            ),
            subject: 'Your Cryptocurrency Newsletter',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Cryptocurrency Newsletter')
            ->markdown('emails.newsletter');
    }
}
