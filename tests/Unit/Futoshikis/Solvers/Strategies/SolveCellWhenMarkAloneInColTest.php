<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInCol;
use PHPUnit\Framework\TestCase;

class SolveCellWhenMarkAloneInColTest extends TestCase
{
    public function testCellGetsValueWhenItIsPresentOnlyInThatCellInTheWholeCol(): void
    {
        $grid = new Grid(3);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(1, 0))->setMarks([2, 3]);
        $grid->getCell(new GridPosition(2, 0))->setMarks([2, 3]);
        $strategy = new SolveCellWhenMarkAloneInCol();
        $strategy->apply($grid);
        $this->assertTrue($grid->getCell(new GridPosition(0, 0))->isFilled());
        $this->assertEquals(1, $grid->getCell(new GridPosition(0, 0))->getValue());
    }

    public function testCellDoesNotGetValueWhenItIsPresentInMoreThanOneCellInTheWholeCol(): void
    {
        $grid = new Grid(3);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(1, 0))->setMarks([1, 3]);
        $grid->getCell(new GridPosition(2, 0))->setMarks([2, 3]);
        $strategy = new SolveCellWhenMarkAloneInCol();
        $strategy->apply($grid);
        $this->assertTrue($grid->getCell(new GridPosition(0, 0))->isEmpty());
    }

    public function testRegressionCell33ShouldNotBeChangedInContext(): void
    {
        $grid = new Grid(4);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2, 3, 4]);
        $grid->getCell(new GridPosition(1, 0))->setMarks([1, 2]);
        $grid->getCell(new GridPosition(2, 0))->setMarks([2, 3,4]);
        $grid->getCell(new GridPosition(3, 0))->setMarks([1,2,3]);
        $grid->getCell(new GridPosition(0, 1))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(1, 1))->setValue(4);
        $grid->getCell(new GridPosition(2, 1))->setMarks([1,2, 3]);
        $grid->getCell(new GridPosition(3, 1))->setMarks([1,2, 3]);
        $grid->getCell(new GridPosition(0, 2))->setMarks([1, 2, 3,4]);
        $grid->getCell(new GridPosition(1, 2))->setMarks([1, 2]);
        $grid->getCell(new GridPosition(2, 2))->setMarks([2, 3,4]);
        $grid->getCell(new GridPosition(3, 2))->setMarks([1,2,3,4]);
        $grid->getCell(new GridPosition(0, 3))->setMarks([1, 2, 4]);
        $grid->getCell(new GridPosition(1, 3))->setValue(3);
        $grid->getCell(new GridPosition(2, 3))->setMarks([4]);
        $grid->getCell(new GridPosition(3, 3))->setMarks([1,2,4]);
        $strategy = new SolveCellWhenMarkAloneInCol();
        $strategy->apply($grid);
        $this->assertEquals([1,2,4], $grid->getCell(new GridPosition(3, 3))->getMarks());
    }
}
