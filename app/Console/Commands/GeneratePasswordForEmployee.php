<?php

namespace App\Console\Commands;

use App\Employee;
use App\Mail\PasswordGenerated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GeneratePasswordForEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:password {employee_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère un nouveau mot de passe pour un employee';

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
        $employee_id = $this->argument('employee_id');
        $password = Str::random(8);
        $hashed_rando_password = Hash::make($password);

        // On met à jour le mot de passe
        $employee = Employee::find($employee_id);
        $employee->password = $hashed_rando_password;
        $employee->save();

        $name = $employee->name . " " . $employee->lastname;

        // On envoi un email pour prévenir du nouveau mot de passe
        Mail::to('dahlen.marvin@leseleveursdelacharentonne.fr')->send(new PasswordGenerated($password, $name));

    }
}
