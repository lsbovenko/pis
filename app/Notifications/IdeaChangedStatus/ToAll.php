<?php

namespace App\Notifications\IdeaChangedStatus;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Idea;

/**
 * Class ToAll
 * @package App\Notifications\IdeaChangedStatus
 */
class ToAll extends Notification
{
    use Queueable;

    /**
     * @var Idea
     */
    protected $idea;

    /**
     * ToAll constructor.
     * @param Idea $idea
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Реализована очередная идея PIS.')
            ->view('emails.idea-changed-status.to-all', [
                'idea' => $this->idea,
            ]);
    }
}
