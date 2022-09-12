<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class SolveCellWhenSingleMarkLeft
{
    public function apply(Grid $grid): bool
    {
        for ($row = 0; $row < $grid->size; $row++) {
            for ($col = 0; $col < $grid->size; $col++) {
                $position = new GridPosition($row, $col);
                $cell = $grid->getCell($position);
                if ($cell->isFilled()) {
                    continue;
                }
                if (count($cell->getMarks()) === 1) {
                    $soleValue = array_values($cell->getMarks())[0];
                    $cell->setValue($soleValue);
                    return true;
                }
            }
        }
        return false;
    }
}
