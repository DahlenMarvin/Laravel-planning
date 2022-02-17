<?php

namespace App\Mail;

use App\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRequest extends Mailable
{

    public $employee;
    public $typeDemande;
    public $poste;
    public $nSemaine;
    public $comment;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Employee $employee
     * @param $typeDemande
     * @param $poste
     * @param $nSemaine
     * @param $comment
     */
    public function __construct(Employee $employee, $typeDemande, $poste, $nSemaine, $comment)
    {
        $this->employee = $employee;
        $this->typeDemande = $typeDemande;
        $this->poste = $poste;
        $this->nSemaine = $nSemaine;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sendRequest')
            ->subject('Nouvelle demande de  ' . $this->employee->name . ' ' . $this->employee->lastname)
            ->from('no-reply@planning-ledlc.fr', 'Administrateur LEDLC')
            ->with([
                'typeDemande' => $this->typeDemande,
                'poste' => $this->poste,
                'nSemaine' => $this->nSemaine,
                'comment' => $this->comment,
                'employee' => $this->employee,
            ]);
    }
}
