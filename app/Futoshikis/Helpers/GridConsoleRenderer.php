<?php

namespace App\Futoshikis\Helpers;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;

class GridConsoleRenderer
{

    public function render(Grid $grid): string
    {
        $cellRenderings = $this->getRenderingsByCell($grid);
        return $this->renderCellsProgressively($grid, $cellRenderings);
    }

    /**
     * @param Grid $grid
     * @return array
     */
    private function getRenderingsByCell(Grid $grid): array
    {
        $result = [];
        for ($row = 0; $row < $grid->size; $row++) {
            for ($col = 0; $col < $grid->size; $col++) {
                $position = new GridPosition($row, $col);
                $cell = $grid->getCell($position);
                if ($cell->isFilled()) {
                    $result[$row][$col] = "   " . PHP_EOL . " " . $cell->getValue() . " " . PHP_EOL . "   ";
                } else {
                    $marks = $cell->getMarks();
                    $cellMarks = "";
                    if (in_array(1, $marks)) {
                        $cellMarks .= "1";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(2, $marks)) {
                        $cellMarks .= "2";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(3, $marks)) {
                        $cellMarks .= "3";
                    } else {
                        $cellMarks .= " ";
                    }
                    $cellMarks .= PHP_EOL;
                    if (in_array(4, $marks)) {
                        $cellMarks .= "4";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(5, $marks)) {
                        $cellMarks .= "5";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(6, $marks)) {
                        $cellMarks .= "6";
                    } else {
                        $cellMarks .= " ";
                    }
                    $cellMarks .= PHP_EOL;
                    if (in_array(7, $marks)) {
                        $cellMarks .= "7";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(8, $marks)) {
                        $cellMarks .= "8";
                    } else {
                        $cellMarks .= " ";
                    }
                    if (in_array(9, $marks)) {
                        $cellMarks .= "9";
                    } else {
                        $cellMarks .= " ";
                    }
                    $result[$row][$col] = $cellMarks;
                }
            }
        }
        return $result;
    }

    private function renderCellsProgressively(Grid $grid, array $cellRenderings): string
    {
        $buffer = "";
        foreach ($cellRenderings as $row => $colRenderings) {

            $row1Buffer = "";
            $row2Buffer = "";
            $row3Buffer = "";
            $row4Buffer = "";
            $row5Buffer = "";

            foreach ($colRenderings as $col => $cellRendering) {

                $ruleSymbol = ' ';
                foreach ($grid->getRules() as $rule) {
                    $startingAt = new GridPosition($row, $col);
                    $goingTo = new GridPosition($row, $col + 1);
                    if ($rule->forPositions($startingAt, $goingTo)) {
                        if ($rule->greaterThanPosition->isEqualTo($startingAt)) {
                            $ruleSymbol = '>';
                        } elseif ($rule->lesserThanPosition->isEqualTo($startingAt)) {
                            $ruleSymbol = '<';
                        }
                    }
                }

                $cellExploded = explode(PHP_EOL, $cellRendering);
                $row1Buffer .= " ---    ";
                $row2Buffer .= "|" . $cellExploded[0] . "|   ";
                $row3Buffer .= "|" . $cellExploded[1] . "| " . $ruleSymbol . " ";
                $row4Buffer .= "|" . $cellExploded[2] . "|   ";
                $row5Buffer .= " ---    ";
            }

            $buffer .= $row1Buffer . PHP_EOL;
            $buffer .= $row2Buffer . PHP_EOL;
            $buffer .= $row3Buffer . PHP_EOL;
            $buffer .= $row4Buffer . PHP_EOL;
            $buffer .= $row5Buffer . PHP_EOL;
            $buffer .= PHP_EOL;
            $buffer .= PHP_EOL;
            $buffer .= PHP_EOL;
        }

        return $buffer;
    }

    /**
     * @param Rule $rule
     * @param mixed $row
     * @return bool
     */
    public function ruleIsForCurrentRow(Rule $rule, mixed $row): bool
    {
        return $rule->greaterThanPosition->row === $row && $rule->lesserThanPosition->row === $row;
    }

    /**
     * @param Rule $rule
     * @param mixed $col
     * @return bool
     */
    public function ruleIsGreaterThanThisCol(Rule $rule, mixed $col): bool
    {
        return ($rule->greaterThanPosition->col === $col || $rule->lesserThanPosition->col + 1 === $col);
    }

    /**
     * @param Rule $rule
     * @param mixed $col
     * @return bool
     */
    public function ruleIsLesserThanThisCol(Rule $rule, mixed $col): bool
    {
        return ($rule->greaterThanPosition->col + 1 === $col || $rule->lesserThanPosition->col === $col);
    }

    /**
     * @param Rule $rule
     * @param int $colLeft
     * @param int $colRight
     * @return bool
     */
    public function ruleIsForTheseTwoColumnIndex(Rule $rule, int $colLeft, int $colRight): bool
    {
        return ($rule->greaterThanPosition->col === $colLeft || $rule->lesserThanPosition->col === $colLeft)
            && ($rule->greaterThanPosition->col === $colRight || $rule->lesserThanPosition->col === $colRight);
    }
}
