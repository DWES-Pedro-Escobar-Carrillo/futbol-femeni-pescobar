<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArbitrePartitsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $partits;
    public $arbitre;

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $partits, User $arbitre)
    {
        $this->partits = $partits;
        $this->arbitre = $arbitre;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assignació de Partits - Futbol Femení',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.arbitre_partits',
            with: [
                'partits' => $this->partits,
                'arbitreName' => $this->arbitre->name,
            ],
        );
    }
}