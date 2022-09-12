<?php

namespace App\Futoshikis\Models;

class Rule
{

    public readonly GridPosition $greaterThanPosition;
    public readonly GridPosition $lessThanPosition;

    public function __construct(GridPosition $greaterThanPosition, GridPosition $lessThanPosition)
    {
        $this->greaterThanPosition = $greaterThanPosition;
        $this->lessThanPosition = $lessThanPosition;
    }

}
