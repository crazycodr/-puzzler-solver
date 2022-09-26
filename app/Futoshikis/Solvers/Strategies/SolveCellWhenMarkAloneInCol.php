<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class SolveCellWhenMarkAloneInCol
{
    private string $appliedMove;

    public function apply(Grid $grid): bool
    {
        for ($col = 0; $col < $grid->size; $col++) {

            $rowsPerValueInCol = [];

            for ($value = 1; $value <= $grid->size; $value++) {
                $rowsPerValueInCol[$value] = [];
            }

            for ($row = 0; $row < $grid->size; $row++) {
                $position = new GridPosition($row, $col);
                foreach ($grid->getCell($position)->getMarks() as $mark) {
                    $rowsPerValueInCol[$mark][] = $row;
                }
            }

            foreach ($rowsPerValueInCol as $value => $rows) {
                if (count($rows) !== 1) {
                    continue;
                }
                $singleRow = array_values($rows)[0];
                $cellToUpdatePosition = new GridPosition($singleRow, $col);
                $cellToUpdate = $grid->getCell($cellToUpdatePosition);
                if ($cellToUpdate->isFilled()) {
                    continue;
                }
                $this->appliedMove = sprintf(
                    'There is only one %s left in column %d, set that value in row %d',
                    $value,
                    $cellToUpdatePosition->col + 1,
                    $cellToUpdatePosition->row + 1
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
