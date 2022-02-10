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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching coin prices.');

        while (true) {
            if ($this->shouldQuit) {
                return false;
            }

            $this->fetchPrices();
            sleep(20);
        }
    }
    
    /**
     * Get the list of signals handled by the command.
     *
     * @return array
     */
    public function getSubscribedSignals(): array
    {
        return [SIGTERM];
    }
    
    /**
     * Handle an incoming signal.
     *
     * @param  int  $signal
     * @return void
     */
    public function handleSignal(int $signal): void
    {
        if ($signal === SIGTERM) {
            $this->shouldQuit = true;

            return;
        }
    }

    protected function fetchPrices()
    {
        $this->info('Fetching...');
        Asset::crypto()->get()->each(function (Asset $asset) {
            UpdateCryptoAssetPrice::dispatch($asset);
        });
    }
}
