<?php

namespace App\Console\Commands;

use App\Activity;
use App\Employee;
use App\Planning;
use App\Signature;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Jenssegers\Agent\Agent;

class generateSignatureForEmployee extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:signature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les semaines à faire visée une fois la fin de semaine arrivée';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nSignatureAdd = 0;
        // Il faut vérifier si une semaine est terminée et s'il existe des events pour cette semaine
        // S'il existe des events on récupère l'id employée et on lui ajoute une semaine a faire validée dans la table Signatures
        $plannings = Planning::all();

        foreach ($plannings as $planning) {
            // On vérifie si la semaine est terminée
            // Si le dernier jour de la semaine est inférieur à aujourd'hui
            $date = Carbon::parse($planning->date)->weekOfYear;
            $annee = Carbon::parse($planning->date)->year;
            $exist = Signature::where('user_id', 24)->where('employee_id', $planning->employee_id)->where('nSemaine', $date)->where('nAnnee', $annee)->get();
            if($exist->count() == 0) {
                //Il n'existe pas donc on le créée dans la base
                Signature::create([
                    'user_id' => 24,
                    'employee_id' => $planning->employee_id,
                    'nSemaine' => $date,
                    'nAnnee' => $annee,
                    'etat' => "En cours"
                ]);
                $nSignatureAdd++;
                Activity::make("Création d'une nouvelle signature semaine n°" . $date . " | Année " . $annee, User::find(24), Employee::find($planning->employee_id), "POST", "Command : generateSignatureForEmployee", "Tache automatique", "Tache automatique", "Tache automatique", "Tache automatique");
            }
        }
        Activity::make("Création de " . $nSignatureAdd . "signature(s)" , null, null, "POST", "Command : generateSignatureForEmployee", "Tache automatique", "Tache automatique", "Tache automatique", "Tache automatique");
    }
}
