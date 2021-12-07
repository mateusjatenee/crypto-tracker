<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class TransactionCollection extends Collection
{
    public function buy(): self
    {
        return $this->where('quantity', '>', 0);
    }

    public function sell(): self
    {
        return $this->where('quantity', '<', 0);
    }
}
