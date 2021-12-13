<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Stat extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public float $value,
        public ?float $increase = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.stat');
    }

    public function formattedValue(): string
    {
        return number_format($this->value, 2);
    }
}
