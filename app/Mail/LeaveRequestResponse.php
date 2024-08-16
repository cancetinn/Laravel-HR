<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;
    public $status;

    public function __construct($leaveRequest, $status)
    {
        $this->leaveRequest = $leaveRequest;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'approved' ? 'İzin Talebiniz Onaylandı' : 'İzin Talebiniz Reddedildi';

        return $this->subject($subject)
                    ->view('emails.leave_request_response');
    }
}
