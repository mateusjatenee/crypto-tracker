<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;
use App\Jobs\UpdateCryptoAssetPrice;
use Symfony\Component\Console\Command\SignalableCommandInterface;

class FetchCoinsPrices extends Command implements SignalableCommandInterface
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
    protected $description = 'Fetch Crypt asset prices';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->newLine();

        $this->line('<bg=yellow;fg=red;options=bold> ATTENTION </> This command runs indefinitely. Press <fg=green>Ctrl + C</> to quit.');
        
        $this->newLine();

        $this->output->write('<fg=green>fetching prices</>', false);

        /** @phpstan-ignore-next-line */
        while (true) {
            $this->fetchPrices();
            sleep(20);
        }
    }


    protected function fetchPrices(): void
    {
        Asset::crypto()->get()->each(function (Asset $asset) {
            UpdateCryptoAssetPrice::dispatch($asset);
            $this->output->write('<fg=green>.</>', false);
        });
    }

    public function handleSignal(int $signal): void
    {
        $this->newLine(2);
        $this->info('<bg=blue;fg=white;options=bold> DONE! </>');
        
        exit(0);
    }


    /**
     *
     * @return  array<int,int>
    */
    public function getSubscribedSignals(): array
    {
        return [SIGINT, SIGTERM];
    }
}
