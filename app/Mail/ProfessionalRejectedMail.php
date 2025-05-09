<?php

namespace App\Mail;

use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessionalRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;
    public $reason;

    public function __construct(Professional $professional, $reason)
    {
        $this->professional = $professional;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Your Application Has Been Rejected')
            ->view('emails.professional_rejected');
    }
}
