<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\CarbonPeriod;

class PositionsChart extends Component
{
    public Account $account;

    public string $type = 'profit';

    public array $types = [
        'profit',
        'total'
    ];

    public function render()
    {
        return view('livewire.positions-chart', [
            'chart' => $this->chart()
        ]);
    }

    public function chart()
    {
        $positionAggregates = $this->account->positionAggregates()
                                            ->with('asset')
                                            ->where('created_at', '>', today()->subMonth())
                                            ->oldest()
                                            ->get()
                                            ->groupBy('asset_id');

        /** @var \Asantibanez\LivewireCharts\Models\LineChartModel */
        $model = LivewireCharts::lineChartModel()
                ->multiLine()
                ->setAnimated(false)
                ->setSmoothCurve(false)
                ->setXAxisVisible(true)
                ->setDataLabelsEnabled(false);

        foreach ($positionAggregates as $asset => $aggregates) {
            $aggregates = $aggregates->unique(
                fn ($position) => $position->created_at->toDateString()
            );

            foreach ($aggregates as $aggregate) {
                $model->addSeriesPoint(
                    $aggregate->assetName(),
                    $aggregate->created_at->toDateString(),
                    (int) $aggregate->{$this->type}()
                );
            }
        }

        return $model;
    }

    public function getTitleProperty(): string
    {
        return match ($this->type) {
            'total' => 'Position over time',
            'profit' => 'Profit over time'
        };
    }
}
