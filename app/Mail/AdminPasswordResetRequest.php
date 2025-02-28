<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('backoffice.emails.password_reset') // Make sure this view exists
                    ->with([
                        'email' => $this->email,
                        'token' => $this->token,  // Pass the token to the view
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Password Reset Request',
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
