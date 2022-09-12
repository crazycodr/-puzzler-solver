<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class UpdateMarksBasedOnVerticalCells
{

    public function apply(Grid $grid): bool
    {
        for ($col = 0; $col < $grid->size; $col++) {
            $solvedValues = $this->getSolvedValues($grid, $col);
            if ($this->removeSolvedMarks($grid, $col, $solvedValues)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Grid $grid
     * @param int $col
     * @return array
     */
    public function getSolvedValues(Grid $grid, int $col): array
    {
        $solvedValues = [];
        for ($row = 0; $row < $grid->size; $row++) {
            $position = new GridPosition($row, $col);
            $cell = $grid->getCell($position);
            if ($cell->isFilled()) {
                $solvedValues[] = $cell->getValue();
            }
        }
        return $solvedValues;
    }

    /**
     * @param Grid $grid
     * @param int $col
     * @param array $solvedValues
     * @return bool
     */
    public function removeSolvedMarks(Grid $grid, int $col, array $solvedValues): bool
    {
        for ($row = 0; $row < $grid->size; $row++) {
            $position = new GridPosition($row, $col);
            $cell = $grid->getCell($position);
            if ($cell->isEmpty()) {
                $currentMarks = $cell->getMarks();
                $newMarks = array_diff($currentMarks, $solvedValues);
                if ($newMarks !== $currentMarks) {
                    $cell->setMarks($newMarks);
                    return true;
                }
            }
        }
        return false;
    }

}
