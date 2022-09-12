<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class RemoveImpossibleMarksBasedOnRules
{
    public function apply(Grid $grid): bool
    {
        foreach ($grid->getRules() as $rule) {
            $greaterThanCell = $grid->getCell($rule->greaterThanPosition);
            $lesserThanCell = $grid->getCell($rule->lesserThanPosition);
            $highestMarkInGreaterThanCell = max($greaterThanCell->getMarks());
            $lowestMarkInLesserThanCell = min($lesserThanCell->getMarks());
            $lowestMarkRemovedFromGreaterThanCellMarks = array_diff($greaterThanCell->getMarks(), range(1, $lowestMarkInLesserThanCell));
            $highestMarkRemovedFromLesserThanCellMarks = array_diff($lesserThanCell->getMarks(), range($highestMarkInGreaterThanCell, $grid->size));
            if ($lowestMarkRemovedFromGreaterThanCellMarks !== $greaterThanCell->getMarks())
            {
                $greaterThanCell->setMarks($lowestMarkRemovedFromGreaterThanCellMarks);
                echo 'lowestMarkRemovedFromGreaterThanCellMarks: ' . $rule->greaterThanPosition->row . ',' . $rule->greaterThanPosition->col . PHP_EOL;
                return true;
            }
            if ($highestMarkRemovedFromLesserThanCellMarks !== $lesserThanCell->getMarks())
            {
                $lesserThanCell->setMarks($highestMarkRemovedFromLesserThanCellMarks);
                echo 'highestMarkRemovedFromLesserThanCellMarks: ' . $rule->lesserThanPosition->row . ',' . $rule->lesserThanPosition->col . PHP_EOL;
                return true;
            }
        }
        return false;
    }
}
