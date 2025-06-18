<?php

namespace App\Mail;

use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessionalDeactivated extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;

    /**
     * Create a new message instance.
     *
     * @param Professional $professional
     */
    public function __construct(Professional $professional)
    {
        $this->professional = $professional;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Account Has Been Deactivated')
                   ->view('emails.professional-deactivated');
    }
}