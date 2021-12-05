<?php

namespace App\Console\Commands;

use App\Jobs\StorePositionAggregatesForAccount;
use App\Models\Account;
use Illuminate\Console\Command;

class StorePositionAggregates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'position-aggregates:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach (Account::all() as $account) {
            StorePositionAggregatesForAccount::dispatch($account);
        }

        return Command::SUCCESS;
    }
}
