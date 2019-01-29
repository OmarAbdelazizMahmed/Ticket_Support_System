<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ticket;
use App\User;
use App\Comment;
class TicketCommented extends Notification
{
    use Queueable;
    public $ticket;
    public $user;
    public $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,Ticket $ticket,$comment)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->with('emails.ticket_comments', ['ticket' => $this->ticket, 'user'=>$this->user,'comment'=>$comment]);
                    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'New Comment Has been added'
        ];
    }
}
