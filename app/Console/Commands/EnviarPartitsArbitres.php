<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Partit;
use App\Mail\ArbitrePartitsMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarPartitsArbitres extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'arbitres:enviar';

    /**
     * The console command description.
     */
    protected $description = 'Envia un correu a cada àrbitre amb els seus propers partits assignats';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Obtenim tots els usuaris que són àrbitres
        $arbitres = User::where('role', 'arbitre')->get();

        $count = 0;

        foreach ($arbitres as $arbitre) {
            // 2. Cerquem els partits futurs assignats a aquest àrbitre
            $partits = Partit::with(['equipLocal', 'equipVisitant', 'estadi'])
                ->where('arbitre_id', $arbitre->id)
                ->where('data', '>=', Carbon::now()) // Només partits futurs
                ->orderBy('data', 'asc')
                ->get();

            // 3. Si té partits assignats, enviem el correu
            if ($partits->count() > 0) {
                Mail::to($arbitre->email)->send(new ArbitrePartitsMail($partits, $arbitre));
                $this->info("Correu enviat a l'àrbitre: " . $arbitre->name);
                $count++;
            }
        }

        if ($count === 0) {
            $this->info('No s\'han trobat àrbitres amb partits futurs assignats.');
        } else {
            $this->info("Procés finalitzat. S'han enviat $count correus.");
        }
    }
}