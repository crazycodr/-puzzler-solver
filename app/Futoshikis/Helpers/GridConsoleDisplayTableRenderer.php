<?php

namespace App\Futoshikis\Helpers;

use App\Futoshikis\Models\Cell;
use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;
use Mmarica\DisplayTable;

class GridConsoleDisplayTableRenderer
{

    private int $largestCellTextValue = 0;

    public function render(Grid $grid): string
    {
        $cellRenderings = $this->getRenderingsByCell($grid);
        $cellRenderings = $this->getRenderingsByRules($grid, $cellRenderings);
        return $this->renderCellsProgressively($cellRenderings);
    }

    /**
     * @param Grid $grid
     * @return array
     */
    private function getRenderingsByCell(Grid $grid): array
    {
        $result = [];
        $this->largestCellTextValue = 0;
        for ($cellRow = 0, $gridRow = 0; $cellRow < $grid->size; $cellRow++, $gridRow += 2) {
            for ($cellCol = 0, $gridCol = 0; $cellCol < $grid->size; $cellCol++, $gridCol += 2) {
                $position = new GridPosition($cellRow, $cellCol);
                $cell = $grid->getCell($position);
                $this->largestCellTextValue = max($this->largestCellTextValue, strlen($this->getCellValueOrMarks($cell)));
            }
        }
        for ($cellRow = 0, $gridRow = 0; $cellRow < $grid->size; $cellRow++, $gridRow += 2) {
            for ($cellCol = 0, $gridCol = 0; $cellCol < $grid->size; $cellCol++, $gridCol += 2) {
                $position = new GridPosition($cellRow, $cellCol);
                $cell = $grid->getCell($position);
                $result = $this->setCellValueOrMarksInResults($cell, $result, $gridRow, $gridCol);
                if ($this->notInLastColumn($position, $grid)) {
                    $result = $this->addInMiddleColumnRuleSymbols($gridCol, $result, $gridRow);
                }
                if ($this->isInLastRow($position, $grid)) {
                    continue;
                }
                $result = $this->addInMiddleRowRuleSymbols($result, $gridRow, $gridCol, $position, $grid);
            }
        }
        return $result;
    }

    private function renderCellsProgressively(array $cellRenderings): string
    {
        return DisplayTable::create()
            ->dataRows($cellRenderings)
            ->toText()->generate();
    }

    /**
     * @param GridPosition $position
     * @param Grid $grid
     * @return bool
     */
    public function notInLastColumn(GridPosition $position, Grid $grid): bool
    {
        return $position->col !== $grid->size - 1;
    }

    /**
     * @param GridPosition $position
     * @param Grid $grid
     * @return bool
     */
    public function isInLastRow(GridPosition $position, Grid $grid): bool
    {
        return $position->row === $grid->size - 1;
    }

    /**
     * @param array $result
     * @param int $gridRow
     * @param int $gridCol
     * @param GridPosition $position
     * @param Grid $grid
     * @return array
     */
    public function addInMiddleRowRuleSymbols(array $result, int $gridRow, int $gridCol, GridPosition $position, Grid $grid): array
    {
        $result[$gridRow + 1][$gridCol] = "";
        if ($position->col !== $grid->size - 1) {
            $result[$gridRow + 1][$gridCol + 1] = "";
        }
        return $result;
    }

    /**
     * @param int $gridCol
     * @param array $result
     * @param int $gridRow
     * @return array
     */
    public function addInMiddleColumnRuleSymbols(int $gridCol, array $result, int $gridRow): array
    {
        $result[$gridRow][$gridCol + 1] = "";
        return $result;
    }

    /**
     * @param Cell $cell
     * @return string
     */
    public function getCellMarks(Cell $cell): string
    {
        return '[' . implode(',', $cell->getMarks()) . ']';
    }

    /**
     * @param Cell $cell
     * @return string
     */
    public function getCellValue(Cell $cell): string
    {
        return $cell->getValue();
    }

    /**
     * @param Cell $cell
     * @param mixed $result
     * @param int $gridRow
     * @param int $gridCol
     * @return array
     */
    public function setCellValueOrMarksInResults(Cell $cell, mixed $result, int $gridRow, int $gridCol): array
    {
        $value = $this->getCellValueOrMarks($cell);
        $result[$gridRow][$gridCol] = str_pad($value, $this->largestCellTextValue,' ', STR_PAD_BOTH);
        return $result;
    }

    /**
     * @param Cell $cell
     * @return string
     */
    public function getCellValueOrMarks(Cell $cell): string
    {
        if ($cell->isFilled()) {
            $value = $this->getCellValue($cell);
        } else {
            $value = $this->getCellMarks($cell);
        }
        return $value;
    }

    private function getRenderingsByRules(Grid $grid, array $cellRenderings): array
    {
        foreach ($grid->getRules() as $rule) {
            if ($this->lesserIsLeftOfGreater($rule)) {
                $x = $rule->lesserThanPosition->row * 2;
                $y = $rule->lesserThanPosition->col * 2 + 1;
                $cellRenderings[$x][$y] = '<';
            } elseif ($this->lesserIsRightOfGreater($rule)) {
                $x = $rule->greaterThanPosition->row * 2;
                $y = $rule->greaterThanPosition->col * 2 + 1;
                $cellRenderings[$x][$y] = '<';
            } elseif ($this->lesserIsAboveOfGreater($rule)) {
                $x = $rule->greaterThanPosition->row * 2 - 1;
                $y = $rule->greaterThanPosition->col * 2;
                $cellRenderings[$x][$y] = str_pad("A", $this->largestCellTextValue, ' ', STR_PAD_BOTH);
            } elseif ($this->lesserIsBelowOfGreater($rule)) {
                $x = $rule->greaterThanPosition->row * 2 + 1;
                $y = $rule->greaterThanPosition->col * 2;
                $cellRenderings[$x][$y] = str_pad("V", $this->largestCellTextValue, ' ', STR_PAD_BOTH);
            }
        }
        return $cellRenderings;
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function lesserIsLeftOfGreater(Rule $rule): bool
    {
        return $rule->lesserThanPosition->row === $rule->greaterThanPosition->row && $rule->lesserThanPosition->col < $rule->greaterThanPosition->col;
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function lesserIsRightOfGreater(Rule $rule): bool
    {
        return $rule->lesserThanPosition->row === $rule->greaterThanPosition->row && $rule->lesserThanPosition->col > $rule->greaterThanPosition->col;
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function lesserIsAboveOfGreater(Rule $rule): bool
    {
        return $rule->lesserThanPosition->row < $rule->greaterThanPosition->row && $rule->lesserThanPosition->col === $rule->greaterThanPosition->col;
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function lesserIsBelowOfGreater(Rule $rule): bool
    {
        return $rule->lesserThanPosition->row > $rule->greaterThanPosition->row && $rule->lesserThanPosition->col === $rule->greaterThanPosition->col;
    }
}
