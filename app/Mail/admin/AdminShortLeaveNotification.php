<?php

namespace App\Mail\admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminShortLeaveNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $shortLeave;

    public function __construct($shortLeave)
    {
        $this->shortLeave = $shortLeave;
    }

    public function build()
    {
        return $this->subject('Yeni Kısa İzin Talebi Alındı')
                    ->view('emails.admin.short_leave_notification');
    }
}
