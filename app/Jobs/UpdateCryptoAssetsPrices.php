<?php

namespace App\Jobs;

use App\MarketInformationProviders\Coinbase;
use App\Models\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateCryptoAssetsPrices implements ShouldQueue
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
    public function __construct()
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
        Asset::crypto()->get()->each(function (Asset $asset) {
            $freshAsset = resolve(Coinbase::class)->fetchAsset($asset);

            if ($freshAsset->price == 0) {
                return;
            }

            $asset->updateFromFreshAsset($freshAsset);
        });
    }
}
