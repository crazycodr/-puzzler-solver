<?php

namespace App\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;

class SolveCellWhenSingleMarkLeft
{
    private string $appliedMove;

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
                    $this->appliedMove = sprintf(
                        'There is only 1 mark left in cell (%d, %d) thus the value in here should be: %s',
                        $row + 1,
                        $col + 1,
                        $soleValue
                    );
                    $cell->setValue($soleValue);
                    return true;
                }
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
