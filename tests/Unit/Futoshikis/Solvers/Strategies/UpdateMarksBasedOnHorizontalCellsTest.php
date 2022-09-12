<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Solvers\Strategies\UpdateMarksBasedOnHorizontalCells;
use PHPUnit\Framework\TestCase;

class UpdateMarksBasedOnHorizontalCellsTest extends TestCase
{
    public function testApplyDoesNotAddMarksToCells(){
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(0,0))->setValue(1);
        $this->assertEquals([], $grid->getCell(new GridPosition(0,1))->getMarks());
        $this->assertEquals([], $grid->getCell(new GridPosition(0,2))->getMarks());
        $this->assertEquals([], $grid->getCell(new GridPosition(0,3))->getMarks());
        $solver = new UpdateMarksBasedOnHorizontalCells();
        $solver->apply($grid);
        $this->assertEquals([], $grid->getCell(new GridPosition(0,1))->getMarks());
        $this->assertEquals([], $grid->getCell(new GridPosition(0,2))->getMarks());
        $this->assertEquals([], $grid->getCell(new GridPosition(0,3))->getMarks());
    }

    public function testApplyReducesMarksFromSolvedCells(){
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(0,0))->setValue(1);
        $grid->getCell(new GridPosition(0,1))->setMarks([1,2,3,4]);
        $grid->getCell(new GridPosition(0,2))->setMarks([1,2,3]);
        $grid->getCell(new GridPosition(0,3))->setMarks([1,2,4]);
        $this->assertEquals([1,2,3,4], $grid->getCell(new GridPosition(0,1))->getMarks());
        $this->assertEquals([1,2,3], $grid->getCell(new GridPosition(0,2))->getMarks());
        $this->assertEquals([1,2,4], $grid->getCell(new GridPosition(0,3))->getMarks());
        $solver = new UpdateMarksBasedOnHorizontalCells();
        $solver->apply($grid);
        $this->assertEquals([2,3,4], $grid->getCell(new GridPosition(0,1))->getMarks());
        $this->assertEquals([2,3], $grid->getCell(new GridPosition(0,2))->getMarks());
        $this->assertEquals([2,4], $grid->getCell(new GridPosition(0,3))->getMarks());
    }
}
