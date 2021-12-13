<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\CarbonPeriod;

class PositionsChart extends Component
{
    public Account $account;

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
                    (int) $aggregate->profit
                );
            }
        }

        return $model;

        $chart = LivewireCharts::lineChartModel();

        foreach (CarbonPeriod::create(today()->subMonth(), today()) as $date) {
            $chart->addPoint(
                $date->format('Y-m-d'),
                $date->format('Y-m-d')
            );
        }

        dd($chart);

        $positionAggregates = $this->account->positionAggregates()
                                            ->where('created_at', '>', today()->subMonth())
                                            ->get();

        // foreach ($positionAggregates as $aggregate) {
        //     $chart->addPoint(
        //         $aggregate->date->toDateString(),
        //         $aggregate->total()
        //     );
        // }

        return $chart;
    }
}
