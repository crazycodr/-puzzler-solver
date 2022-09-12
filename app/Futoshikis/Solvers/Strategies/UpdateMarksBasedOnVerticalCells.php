<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class UpdateMarksBasedOnVerticalCells
{

    public function apply(Grid $grid): void
    {
        for ($col = 0; $col < $grid->size; $col++) {
            $solvedValues = $this->getSolvedValues($grid, $col);
            $this->removeSolvedMarks($grid, $col, $solvedValues);
        }
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
     * @return void
     */
    public function removeSolvedMarks(Grid $grid, int $col, array $solvedValues): void
    {
        for ($row = 0; $row < $grid->size; $row++) {
            $position = new GridPosition($row, $col);
            $cell = $grid->getCell($position);
            if ($cell->isEmpty()) {
                $currentMarks = $cell->getMarks();
                $newMarks = array_diff($currentMarks, $solvedValues);
                $cell->setMarks($newMarks);
            }
        }
    }

}
