<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShortLeaveRequestResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $shortLeave;
    public $status;

    public function __construct($shortLeave, $status)
    {
        $this->shortLeave = $shortLeave;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'approve' ? 'Kısa İzin Talebiniz Onaylandı' : 'Kısa İzin Talebiniz Reddedildi';

        return $this->subject($subject)
                    ->view('emails.short_leave_request_response');
    }
}
