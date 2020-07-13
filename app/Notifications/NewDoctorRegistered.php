<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDoctorRegistered extends Notification
{
    use Queueable;

    private $new_doctor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $new_doctor)
    {
        $this->new_doctor = $new_doctor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Create the mail representation of the notification when new doctor registered.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('New doctor has registered with email ' . $this->new_doctor->email)
                    ->action('Approve user', route('admin.doctors.approve', $this->new_doctor->id));
    }

    /**
     * Create database notification for admin user when new doctor registered
     * @return array
     */
    public function toDatabase() {
        return [
          'message' => $this->new_doctor->name . ' Requested appproval for new account.',
        ];
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
            //
        ];
    }
}
