<?php

namespace App\Futoshikis\Models;

class Rule
{

    public readonly GridPosition $lesserThanPosition;
    public readonly GridPosition $greaterThanPosition;

    public function __construct(GridPosition $lesserThanPosition, GridPosition $greaterThanPosition)
    {
        $this->lesserThanPosition = $lesserThanPosition;
        $this->greaterThanPosition = $greaterThanPosition;
    }

}
