<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CorreoElectronicoNotification extends Notification
{
    use Queueable;
    
    public $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
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
        $id_user = $this->usuario->id;
        $datos = DB::select('SELECT clientes.nombre AS nombre_cliente FROM presupuestos JOIN clientes ON presupuestos.id_cliente = clientes.NIC WHERE presupuestos.id_user = '.$id_user.' ORDER BY presupuestos.id DESC LIMIT 1;');
        $primerResultado  = $datos[0];
        $name = $primerResultado->nombre_cliente;

        return (new MailMessage)
            ->subject('Nueva Cotización para el cliente: '.$name.'')
            ->greeting('¡Hola!')
            ->line('Hemos recibido una nueva cotización de parte del usuario ' . $this->usuario->name . '.')
            ->line('Puedes ver más detalles sobre esta cotización haciendo clic en el siguiente enlace:')
            ->action('Ver detalles de la cotización', url('https://enterprise.energy4cero.com/public/presupuestos'))
            ->line('¡Gracias por utilizar nuestra aplicación!')
            ->salutation('Saludos, El equipo de Energy 4.0');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
