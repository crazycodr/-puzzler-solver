<?php

namespace Tests\Unit\Futoshikis\Solvers;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;
use App\Futoshikis\Solvers\GridSolver;
use App\Futoshikis\Solvers\Strategies\RemoveImpossibleMarksBasedOnRules;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInCol;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInRow;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenSingleMarkLeft;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnHorizontalCells;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnVerticalCells;
use PHPUnit\Framework\TestCase;

class GridSolverTest extends TestCase
{
    public function testSolverAgainstFixture4(): void
    {
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(1, 3))->setValue(3);
        $grid
            ->addRule(new Rule(new GridPosition(1, 0), new GridPosition(1,1)))
            ->addRule(new Rule(new GridPosition(3, 0), new GridPosition(2,0)))
            ->addRule(new Rule(new GridPosition(1, 2), new GridPosition(2,2)))
            ->addRule(new Rule(new GridPosition(1, 3), new GridPosition(2,3)));
        $solver = new GridSolver(
            new UpdateMarksBasedOnHorizontalCells(),
            new UpdateMarksBasedOnVerticalCells(),
            new RemoveImpossibleMarksBasedOnRules(),
            new SolveCellWhenSingleMarkLeft(),
            new SolveCellWhenMarkAloneInRow(),
            new SolveCellWhenMarkAloneInCol()
        );
        $solver->solve($grid);
        $this->assertTrue($grid->isSolved());
    }

    public function testSolverAgainstFixture5(): void
    {
        $grid = new Grid(5);
        $grid->getCell(new GridPosition(0, 3))->setValue(2);
        $grid
            ->addRule(new Rule(new GridPosition(0, 1), new GridPosition(0,0)))
            ->addRule(new Rule(new GridPosition(0, 1), new GridPosition(0,2)))
            ->addRule(new Rule(new GridPosition(0, 4), new GridPosition(0,3)))
            ->addRule(new Rule(new GridPosition(1, 1), new GridPosition(1,0)))
            ->addRule(new Rule(new GridPosition(1, 0), new GridPosition(2,0)))
            ->addRule(new Rule(new GridPosition(4,0), new GridPosition(3,0)))
            ->addRule(new Rule(new GridPosition(3,0), new GridPosition(3,1)))
            ->addRule(new Rule(new GridPosition(1,4), new GridPosition(1,3)))
            ->addRule(new Rule(new GridPosition(4,3), new GridPosition(3,3)))
            ->addRule(new Rule(new GridPosition(4,4), new GridPosition(3,4)));
        $solver = new GridSolver(
            new UpdateMarksBasedOnHorizontalCells(),
            new UpdateMarksBasedOnVerticalCells(),
            new RemoveImpossibleMarksBasedOnRules(),
            new SolveCellWhenSingleMarkLeft(),
            new SolveCellWhenMarkAloneInRow(),
            new SolveCellWhenMarkAloneInCol()
        );
        $solver->solve($grid);
        $this->assertTrue($grid->isSolved());
    }

    public function testSolverAgainstFixture7(): void
    {
        $grid = new Grid(7);
        $grid->getCell(new GridPosition(2, 0))->setValue(4);
        $grid->getCell(new GridPosition(4, 0))->setValue(2);
        $grid->getCell(new GridPosition(6, 1))->setValue(6);
        $grid
            ->addRule(new Rule(new GridPosition(0, 4), new GridPosition(0,3)))
            ->addRule(new Rule(new GridPosition(0, 3), new GridPosition(0,2)))
            ->addRule(new Rule(new GridPosition(0, 2), new GridPosition(0,1)))
            ->addRule(new Rule(new GridPosition(0, 1), new GridPosition(0,0)))
            ->addRule(new Rule(new GridPosition(0, 2), new GridPosition(1,2)))
            ->addRule(new Rule(new GridPosition(1, 2), new GridPosition(1,1)))

            ->addRule(new Rule(new GridPosition(0, 6), new GridPosition(1,6)))

            ->addRule(new Rule(new GridPosition(2, 1), new GridPosition(2,0)))
            ->addRule(new Rule(new GridPosition(2, 2), new GridPosition(2,1)))

            ->addRule(new Rule(new GridPosition(2, 6), new GridPosition(2,5)))

            ->addRule(new Rule(new GridPosition(3, 1), new GridPosition(3,0)))

            ->addRule(new Rule(new GridPosition(3, 3), new GridPosition(3,2)))

            ->addRule(new Rule(new GridPosition(3, 6), new GridPosition(3,5)))

            ->addRule(new Rule(new GridPosition(4, 1), new GridPosition(4,0)))

            ->addRule(new Rule(new GridPosition(4, 4), new GridPosition(3,4)))
            ->addRule(new Rule(new GridPosition(4, 4), new GridPosition(4,3)))
            ->addRule(new Rule(new GridPosition(4, 5), new GridPosition(4,4)))
            ->addRule(new Rule(new GridPosition(4, 5), new GridPosition(4,6)))
            ->addRule(new Rule(new GridPosition(4, 6), new GridPosition(5,6)))
            ->addRule(new Rule(new GridPosition(4, 4), new GridPosition(5,4)))
            ->addRule(new Rule(new GridPosition(4, 3), new GridPosition(5,3)))

            ->addRule(new Rule(new GridPosition(5, 2), new GridPosition(6,2)))
            ->addRule(new Rule(new GridPosition(5, 2), new GridPosition(5,1)))
            ->addRule(new Rule(new GridPosition(5, 1), new GridPosition(5,0)))

            ->addRule(new Rule(new GridPosition(6, 1), new GridPosition(6,0)));
        $solver = new GridSolver(
            new UpdateMarksBasedOnHorizontalCells(),
            new UpdateMarksBasedOnVerticalCells(),
            new RemoveImpossibleMarksBasedOnRules(),
            new SolveCellWhenSingleMarkLeft(),
            new SolveCellWhenMarkAloneInRow(),
            new SolveCellWhenMarkAloneInCol()
        );
        $solver->solve($grid);
        $this->assertTrue($grid->isSolved());
    }
}
