<?php

namespace App\Futoshikis\Solvers;

use App\Futoshikis\Helpers\GridConsoleRenderer;
use App\Futoshikis\Models\Grid;
use App\Futoshikis\Solvers\Strategies\RemoveImpossibleMarksBasedOnRules;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInCol;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInRow;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenSingleMarkLeft;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnHorizontalCells;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnVerticalCells;

class GridSolver
{

    private UpdateMarksBasedOnHorizontalCells $updateMarksBasedOnHorizontalCells;
    private UpdateMarksBasedOnVerticalCells $updateMarksBasedOnVerticalCells;
    private RemoveImpossibleMarksBasedOnRules $removeImpossibleMarksBasedOnRules;
    private SolveCellWhenSingleMarkLeft $solveCellWhenSingleMarkLeft;
    private SolveCellWhenMarkAloneInRow $solveCellWhenMarkAloneInRow;
    private SolveCellWhenMarkAloneInCol $solveCellWhenMarkAloneInCol;

    public function __construct(
        UpdateMarksBasedOnHorizontalCells $updateMarksBasedOnHorizontalCells,
        UpdateMarksBasedOnVerticalCells $updateMarksBasedOnVerticalCells,
        RemoveImpossibleMarksBasedOnRules $removeImpossibleMarksBasedOnRules,
        SolveCellWhenSingleMarkLeft $solveCellWhenSingleMarkLeft,
        SolveCellWhenMarkAloneInRow $solveCellWhenMarkAloneInRow,
        SolveCellWhenMarkAloneInCol $solveCellWhenMarkAloneInCol
    )
    {
        $this->updateMarksBasedOnHorizontalCells = $updateMarksBasedOnHorizontalCells;
        $this->updateMarksBasedOnVerticalCells = $updateMarksBasedOnVerticalCells;
        $this->removeImpossibleMarksBasedOnRules = $removeImpossibleMarksBasedOnRules;
        $this->solveCellWhenSingleMarkLeft = $solveCellWhenSingleMarkLeft;
        $this->solveCellWhenMarkAloneInRow = $solveCellWhenMarkAloneInRow;
        $this->solveCellWhenMarkAloneInCol = $solveCellWhenMarkAloneInCol;
    }

    public function solve(Grid $grid): void
    {
        $triesLeft = 1000;
        while ($triesLeft > 0 && $grid->isSolved() === false) {
            $renderer = new GridConsoleRenderer();
            echo $renderer->render($grid);
            echo "-------------------------------" . PHP_EOL;
            if ($this->updateMarksBasedOnHorizontalCells->apply($grid)) {
                echo 'updateMarksBasedOnHorizontalCells' . PHP_EOL;
                continue;
            }
            if ($this->updateMarksBasedOnVerticalCells->apply($grid)) {
                echo 'updateMarksBasedOnVerticalCells' . PHP_EOL;
                continue;
            }
            if ($this->removeImpossibleMarksBasedOnRules->apply($grid)) {
                echo 'removeImpossibleMarksBasedOnRules' . PHP_EOL;
                continue;
            }
            if ($this->solveCellWhenSingleMarkLeft->apply($grid)) {
                echo 'solveCellWhenSingleMarkLeft' . PHP_EOL;
                continue;
            }
            if ($this->solveCellWhenMarkAloneInRow->apply($grid)) {
                echo 'solveCellWhenMarkAloneInRow' . PHP_EOL;
                continue;
            }
            if ($this->solveCellWhenMarkAloneInCol->apply($grid)) {
                echo 'solveCellWhenMarkAloneInCol' . PHP_EOL;
                continue;
            }
            $triesLeft--;
        }
    }

}
