<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckRecordatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checRecordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para checkear recordatorios';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }

    
    public function __invoke()
    {
        
    }

}
