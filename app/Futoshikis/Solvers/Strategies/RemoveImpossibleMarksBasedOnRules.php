<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class RemoveImpossibleMarksBasedOnRules
{
    public function apply(Grid $grid): void
    {
        foreach ($grid->getRules() as $rule) {
            $greaterThanCell = $grid->getCell($rule->greaterThanPosition);
            $lesserThanCell = $grid->getCell($rule->lesserThanPosition);
            $highestMarkInGreaterThanCell = max($greaterThanCell->getMarks());
            $lowestMarkInLesserThanCell = min($lesserThanCell->getMarks());
            $lowestMarkRemovedFromGreaterThanCellMarks = array_diff($greaterThanCell->getMarks(), [$lowestMarkInLesserThanCell]);
            $highestMarkRemovedFromLesserThanCellMarks = array_diff($lesserThanCell->getMarks(), [$highestMarkInGreaterThanCell]);
            $greaterThanCell->setMarks($lowestMarkRemovedFromGreaterThanCellMarks);
            $lesserThanCell->setMarks($highestMarkRemovedFromLesserThanCellMarks);
        }
    }
}
