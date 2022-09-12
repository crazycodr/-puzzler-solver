<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class SolveCellWhenMarkAloneInCol
{
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
                $cellToUpdate->setValue($value);
                return true;
            }
        }
        return false;
    }
}
