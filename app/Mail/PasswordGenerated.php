<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class PasswordGenerated extends Mailable
{
    use Queueable, SerializesModels, sendgrid;

    public $password;
    public $name;

    /**
     * Create a new message instance.
     *
     * @param String $password
     */
    public function __construct($password, $name)
    {
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.passwordGenerated')
                    ->subject('Nouveau mot de passe pour ' . $this->name)
                    ->from('no-reply@planning-ledlc.fr', 'Administrateur LEDLC')
                    ->with([
                        'password' => $this->password,
                        'name' => $this->name,
                    ]);
    }
}
