<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
class PasswordReset extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $token;

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
        return (new MailMessage)
            ->subject('Redefinição de Senha - Unisa')
            ->greeting('Prezado (a), ')
            ->line('Você pode redefinir sua senha. Para isso, basta clicar no botão Redefinir Senha.')
            ->line(new HtmlString('Se tiver dúvidas, pode nos contatar pelo 0800 171 796 ou pelo WhatsApp, clicando <a href="https://api.whatsapp.com/send?phone=551121418555">aqui</a>'))
            ->action('Redefinir Senha', route('password.reset', [$this->token, encrypt($notifiable->email)]))
            ->line('Atenciosamente,')
            ->line('Universidade Santo Amaro – UNISA')
            ->line('Visite nosso site: www.unisa.br');
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
