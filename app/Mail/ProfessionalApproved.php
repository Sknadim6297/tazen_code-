<?php


namespace App\Mail;

use App\Models\Professional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessionalApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $professional;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Professional $professional
     * @return void
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
        return $this->view('emails.approved')
            ->with([
                'name' => $this->professional->name,
                'approvalMessage' => 'Your profile has been approved successfully!'
            ])
            ->subject('Your profile has been approved');
    }
}
