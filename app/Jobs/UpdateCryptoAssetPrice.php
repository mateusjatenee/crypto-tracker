<?php

namespace App\Jobs;

use App\Models\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\MarketInformationProviders\Coinbase;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateCryptoAssetPrice implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Asset $asset)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $freshAsset = resolve(Coinbase::class)->fetchAsset($this->asset);

        if ($freshAsset->price == 0) {
            return;
        }

        $this->asset->updateFromFreshAsset($freshAsset);
    }
}
