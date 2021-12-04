<?php

namespace App\Console\Commands;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Console\Command;

class LoadCryptoAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto-assets:load';

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
        foreach ($this->getAssets() as $asset) {
            Asset::firstOrCreate(['code' => $asset['code']], [
                'name' => $asset['name'],
                'type' => AssetType::CRYPTO
            ]);
        }

        $this->info('Loaded.');
    }

    public function getAssets(): array
    {
        return [
            [
                'name' => 'Bitcoin',
                'code' => 'BTC'
            ],
            [
                'name' => 'Ethereum',
                'code' => 'ETH'
            ],
            [
                'name' => 'Solana',
                'code' => 'SOL'
            ],
            [
                'name' => 'Tether',
                'code' => 'USDT'
            ],
            [
                'name' => 'Cardano',
                'code' => 'ADA'
            ],
            [
                'name' => 'Binance Coin',
                'code' => 'BNB'
            ],
            [
                'name' => 'XRP',
                'code' => 'XRP'
            ],
            [
                'name' => 'Polkadot',
                'code' => 'DOT'
            ]
        ];
    }
}
