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

    public function forPositions(GridPosition $startingAt, GridPosition $goingTo):bool
    {
        if ($this->greaterThanPosition->isEqualTo($startingAt) || $this->lesserThanPosition->isEqualTo($goingTo)){
            return true;
        }
        if ($this->greaterThanPosition->isEqualTo($goingTo) || $this->lesserThanPosition->isEqualTo($startingAt)){
            return true;
        }
        return false;
    }

}
