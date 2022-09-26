<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class SolveCellWhenMarkAloneInRow
{
    private string $appliedMove;

    public function apply(Grid $grid): bool
    {
        for ($row = 0; $row < $grid->size; $row++) {

            $colsPerValueInRow = [];

            for ($value = 1; $value <= $grid->size; $value++) {
                $colsPerValueInRow[$value] = [];
            }

            for ($col = 0; $col < $grid->size; $col++) {
                $position = new GridPosition($row, $col);
                foreach ($grid->getCell($position)->getMarks() as $mark) {
                    $colsPerValueInRow[$mark][] = $col;
                }
            }

            foreach ($colsPerValueInRow as $value => $cols) {
                if (count($cols) !== 1) {
                    continue;
                }
                $singleCol = array_values($cols)[0];
                $cellToUpdatePosition = new GridPosition($row, $singleCol);
                $cellToUpdate = $grid->getCell($cellToUpdatePosition);
                if ($cellToUpdate->isFilled()) {
                    continue;
                }
                $this->appliedMove = sprintf(
                    'There is only one %s left in row %d, set that value in column %d',
                    $value,
                    $row + 1,
                    $col + 1
                );
                $cellToUpdate->setValue($value);
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
