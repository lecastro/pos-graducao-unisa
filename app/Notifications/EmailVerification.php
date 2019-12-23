<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailVerification extends VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    // private $name;

    public function __construct()
    {
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
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return (new MailMessage)
            ->subject('Validação de Conta – Unisa')
            ->greeting('Prezado(a), ')
            ->line('Você acaba de acessar o Painel do Candidato da Unisa.')
            ->line('Para que a sua conta tenha validade é necessário clicar no botão Validar Conta.')
            ->line(new HtmlString('Se tiver dúvidas, pode nos contatar pelo 0800 171 796 ou pelo WhatsApp, clicando <a href="https://api.whatsapp.com/send?phone=551121418555">aqui</a>'))
            ->action('Validar conta', url($this->verificationUrl($notifiable)))
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
