<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentalNotification extends Mailable
{
    public $rental;

    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    public function build()
    {
        return $this->subject('Car Rental Confirmation')
                    ->view('emails.rental')
                    ->with(['rental' => $this->rental]);
    }
}
