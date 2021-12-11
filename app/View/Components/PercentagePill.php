<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PercentagePill extends Component
{
    public $percentage;

    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.percentage-pill');
    }

    public function color(): string
    {
        if ($this->percentage > 0) {
            return 'green';
        } elseif ($this->percentage < 0) {
            return 'red';
        }

        return 'blue';
    }

    public function svgContent(): string
    {
        if ($this->percentage > 0) {
            return "M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z";
        }

        return "M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z";
    }
}
