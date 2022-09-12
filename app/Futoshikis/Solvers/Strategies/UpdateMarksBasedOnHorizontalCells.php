<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class UpdateMarksBasedOnHorizontalCells
{

    public function apply(Grid $grid): bool
    {
        for ($row = 0; $row < $grid->size; $row++) {
            $solvedValues = $this->getSolvedValues($grid, $row);
            if ($this->removeSolvedMarks($grid, $row, $solvedValues)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Grid $grid
     * @param int $row
     * @return array
     */
    public function getSolvedValues(Grid $grid, int $row): array
    {
        $solvedValues = [];
        for ($col = 0; $col < $grid->size; $col++) {
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
     * @param int $row
     * @param array $solvedValues
     * @return bool
     */
    public function removeSolvedMarks(Grid $grid, int $row, array $solvedValues): bool
    {
        for ($col = 0; $col < $grid->size; $col++) {
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
