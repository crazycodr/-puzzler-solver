<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInRow;
use PHPUnit\Framework\TestCase;

class SolveCellWhenMarkAloneInRowTest extends TestCase
{
    public function testCellGetsValueWhenItIsPresentOnlyInThatCellInTheWholeRow(): void
    {
        $grid = new Grid(3);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(0, 1))->setMarks([2, 3]);
        $grid->getCell(new GridPosition(0, 2))->setMarks([2, 3]);
        $strategy = new SolveCellWhenMarkAloneInRow();
        $strategy->apply($grid);
        $this->assertTrue($grid->getCell(new GridPosition(0, 0))->isFilled());
        $this->assertEquals(1, $grid->getCell(new GridPosition(0, 0))->getValue());
    }

    public function testCellDoesNotGetValueWhenItIsPresentInMoreThanOneCellInTheWholeRow(): void
    {
        $grid = new Grid(3);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2, 3]);
        $grid->getCell(new GridPosition(0, 1))->setMarks([1, 3]);
        $grid->getCell(new GridPosition(0, 2))->setMarks([2, 3]);
        $strategy = new SolveCellWhenMarkAloneInRow();
        $strategy->apply($grid);
        $this->assertTrue($grid->getCell(new GridPosition(0, 0))->isEmpty());
    }
}
