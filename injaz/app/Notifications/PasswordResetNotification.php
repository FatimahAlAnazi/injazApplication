<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
       // $urlToResetForm = "http://127.0.0.1:8000/vue-app/reset-password-form/?token=". $this->token;
      //  $urlToResetForm = "http://fierce-lake-47191.herokuapp.com/api/vue-app/reset-password-form/?token=". $this->token;
       // $urlToResetForm = "http://fierce-lake-47191.herokuapp.com/api/password/reset";
        return (new MailMessage)
            ->subject(Lang::get('Hey! Reset Password Notification'))
            ->line(Lang::get('You requested here you go!'))
          //  ->action(Lang::get('Reset Password'), $urlToResetForm)
          //  ->action(Lang::get('Reset Password'), url('/password/reset', $this->token))
           ->action(Lang::get('Reset Password'), url('api/password/reset')) // الأخيرة

          ->action(Lang::get('Reset Password'), url('api/password/reset' , $this->token)) // التجربة

            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required. Token: ==>'. $this->token));

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

//no need (for test only)
//->action(Lang::get('Reset Password'), url('/password/reset/link'))
