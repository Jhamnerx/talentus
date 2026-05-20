<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public string $messageBody,
        public string $eventType = 'update'  // 'created' | 'update' | 'resolved' | 'closed'
    ) {}

    public function envelope(): Envelope
    {
        $fromEmail = config('tickets.from_email', config('mail.from.address')) ?? '';
        $fromName  = config('tickets.from_name', config('mail.from.name')) ?? 'Soporte';

        $subjectPrefix = match ($this->eventType) {
            'created'  => '[Nuevo ticket]',
            'resolved' => '[Resuelto]',
            'closed'   => '[Cerrado]',
            default    => '[Actualización]',
        };

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject: "{$subjectPrefix} [{$this->ticket->code}] {$this->ticket->subject}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.tickets.customer-update',
        );
    }
}
