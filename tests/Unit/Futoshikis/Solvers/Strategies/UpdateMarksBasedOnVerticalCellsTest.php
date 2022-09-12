<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnVerticalCells;
use PHPUnit\Framework\TestCase;

class UpdateMarksBasedOnVerticalCellsTest extends TestCase
{
    public function testApplyDoesNotAddMarksToCells()
    {
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(0, 0))->setValue(1);
        $grid->getCell(new GridPosition(1,0))->setMarks([2,3]);
        $grid->getCell(new GridPosition(2,0))->setMarks([2,3]);
        $grid->getCell(new GridPosition(3,0))->setMarks([2,3]);
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(1, 0))->getMarks());
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(2, 0))->getMarks());
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(3, 0))->getMarks());
        $solver = new UpdateMarksBasedOnVerticalCells();
        $solver->apply($grid);
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(1, 0))->getMarks());
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(2, 0))->getMarks());
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(3, 0))->getMarks());
    }

    public function testApplyReducesMarksFromSolvedCells()
    {
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(0, 0))->setValue(1);
        $grid->getCell(new GridPosition(1, 0))->setMarks([1, 2, 3, 4]);
        $grid->getCell(new GridPosition(2, 0))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(3, 0))->setMarks([1, 2, 4]);
        $this->assertEquals([1, 2, 3, 4], $grid->getCell(new GridPosition(1, 0))->getMarks());
        $this->assertEquals([1, 2, 3], $grid->getCell(new GridPosition(2, 0))->getMarks());
        $this->assertEquals([1, 2, 4], $grid->getCell(new GridPosition(3, 0))->getMarks());
        $solver = new UpdateMarksBasedOnVerticalCells();
        $solver->apply($grid);
        $this->assertEquals([2, 3, 4], $grid->getCell(new GridPosition(1, 0))->getMarks());
        $this->assertEquals([2, 3], $grid->getCell(new GridPosition(2, 0))->getMarks());
        $this->assertEquals([2, 4], $grid->getCell(new GridPosition(3, 0))->getMarks());
    }
}
