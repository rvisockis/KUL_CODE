<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\OracleLivingSubject;
use App\OracleSicknessCase;
use App\OracleVisit;

class CheckPatientIsLive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkpatientis:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check patient is live or not';

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
        OracleLivingSubject::chunk(200, function($users)
        {
            foreach ($users as $user)
            {
                //
            }
        });
    }
}
