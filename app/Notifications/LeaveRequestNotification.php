<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRequestNotification extends Notification
{
    use Queueable;

    protected $leaveRequest;
    protected $status;

    public function __construct($leaveRequest, $status = null)
    {
        $this->leaveRequest = $leaveRequest;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->status === 'approved' 
            ? 'İzin Talebiniz Onaylandı' 
            : ($this->status === 'rejected' 
                ? 'İzin Talebiniz Reddedildi' 
                : 'Yeni İzin Talebi Alındı');

        $viewData = [
            'subject' => $subject,
            'user' => $this->leaveRequest->user,
            'status' => $this->status,
            'start_date' => $this->leaveRequest->start_date,
            'end_date' => $this->leaveRequest->end_date,
            'rejection_reason' => $this->leaveRequest->rejection_reason ?? '',
        ];

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.leave_request', $viewData);
    }
}
