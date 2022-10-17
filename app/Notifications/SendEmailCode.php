<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailCode extends Notification
{
    use Queueable;

    /**
     * Одноразовый код
     * @var string
     */
    public $code;

    /**
     * язык
     * @var string|null
     */
    public $locale;



    /**
     * Create a new notification instance.
     *
     * @param string $code
     * @param string $locale
     * @return void
     */
    public function __construct(string $code, ?string $locale = NULL)
    {
        $this->code = $code;
        $this->locale = $locale ?? config('app.locale');
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

    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        app()->setlocale($this->locale);
        $address = config('mail.from.address');
        $name = config('mail.from.name');

        return (new MailMessage)
            ->subject('Student Residence - ' . __('emails.code.title', [], $this->locale),)
            ->from($address, $name)
            ->view('emails.code', [
                'title' => __('emails.code.title', [], $this->locale),
                'content' => __('emails.code.content', ['code' => $this->code,], $this->locale),
            ]);
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
