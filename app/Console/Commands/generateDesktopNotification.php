<?php

namespace App\Console\Commands;

use App\Employee;
use App\Signature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class generateDesktopNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les notifications si la signature de la semaine du planning n\'est pas encore faite';

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
        $this->alert('Début du programme');

        // On récupère les plannings qui ne sont pas signés
        $weekNumber = Carbon::now()->subWeek()->weekOfYear;
        $year = Carbon::now()->subWeek()->format('Y');
        $signatures = Signature::where('etat', 'En cours')->where('nSemaine', $weekNumber)->where('nAnnee', $year)->get();

        $db = DB::connection("mysql2");
        var_dump($db->select('SHOW TABLES'));

        //On parcours les notifications en attente de signature
        // A chaque notification on génère une notification
        /*
        foreach ($signatures as $signature) {
            //On récupère les informations de l'employée
            $employee = Employee::find($signature->user_id);
            DB::connection('notification')->table('notifications')->insert([
                'agent_id'  => $employee->user_id,
                'title'     => "Absence de signature",
                'comment'   => $employee->name . " " . $employee->lastname,
                'state'     => 0
            ]);
        }
        */

        $this->alert('Fin du programme');
    }
}
