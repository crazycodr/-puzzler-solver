<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class RemoveImpossibleMarksBasedOnRules
{
    private string $appliedMove;

    public function apply(Grid $grid): bool
    {
        foreach ($grid->getRules() as $rule) {
            $greaterThanCell = $grid->getCell($rule->greaterThanPosition);
            $lesserThanCell = $grid->getCell($rule->lesserThanPosition);
            $lowestMarkInLesserThanCell = min($lesserThanCell->getMarks());
            $lowestMarkRemovedFromGreaterThanCellMarks = array_diff($greaterThanCell->getMarks(), range(1, $lowestMarkInLesserThanCell));
            $markRemoved = array_diff($greaterThanCell->getMarks(), $lowestMarkRemovedFromGreaterThanCellMarks);
            if ($lowestMarkRemovedFromGreaterThanCellMarks !== $greaterThanCell->getMarks())
            {
                $greaterThanCell->setMarks($lowestMarkRemovedFromGreaterThanCellMarks);
                $this->appliedMove = sprintf('Based on rule between (%d, %d) < (%d, %d), you cannot have marks %s in the greater than cell (%d, %d)', $rule->lesserThanPosition->row + 1, $rule->lesserThanPosition->col + 1, $rule->greaterThanPosition->row + 1, $rule->greaterThanPosition->col + 1, implode(',', $markRemoved), $rule->greaterThanPosition->row + 1, $rule->greaterThanPosition->col + 1);
                return true;
            }
            $highestMarkInGreaterThanCell = max($greaterThanCell->getMarks());
            $highestMarkRemovedFromLesserThanCellMarks = array_diff($lesserThanCell->getMarks(), range($highestMarkInGreaterThanCell, $grid->size));
            $markRemoved = array_diff($lesserThanCell->getMarks(), $highestMarkRemovedFromLesserThanCellMarks);
            if ($highestMarkRemovedFromLesserThanCellMarks !== $lesserThanCell->getMarks())
            {
                $lesserThanCell->setMarks($highestMarkRemovedFromLesserThanCellMarks);
                $this->appliedMove = sprintf('Based on rule between (%d, %d) < (%d, %d), you cannot have marks %s in the less than cell (%d, %d)', $rule->lesserThanPosition->row + 1, $rule->lesserThanPosition->col + 1, $rule->greaterThanPosition->row + 1, $rule->greaterThanPosition->col + 1, implode(',', $markRemoved), $rule->lesserThanPosition->row + 1, $rule->lesserThanPosition->col + 1);
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getAppliedMove(): string
    {
        return $this->appliedMove;
    }
}
