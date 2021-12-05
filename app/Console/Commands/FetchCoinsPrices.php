<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCryptoAssetPrice;
use App\Models\Asset;
use Illuminate\Console\Command;

class FetchCoinsPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coins:fetch-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $shouldQuit = false;

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
        $this->info('Fetching coin prices.');

        $this->listenForSignals();

        while (true) {
            if ($this->shouldQuit) {
                return false;
            }

            $this->fetchPrices();
            sleep(20);
        }
    }

    public function listenForSignals()
    {
        pcntl_signal(SIGTERM, function () {
            $this->shouldQuit = true;
        });
    }

    protected function fetchPrices()
    {
        $this->info('Fetching...');
        Asset::crypto()->get()->each(function (Asset $asset) {
            UpdateCryptoAssetPrice::dispatch($asset);
        });
    }
}
