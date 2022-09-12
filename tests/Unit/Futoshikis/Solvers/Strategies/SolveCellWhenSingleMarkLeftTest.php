<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenSingleMarkLeft;
use PHPUnit\Framework\TestCase;

class SolveCellWhenSingleMarkLeftTest extends TestCase
{
    public function testApplyWillSetValueIfOneMarkLeft(): void
    {
        $grid = new Grid(2);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1]);
        $strategy = new SolveCellWhenSingleMarkLeft();
        $strategy->apply($grid);
        $this->assertEquals(1, $grid->getCell(new GridPosition(0, 0))->getValue());
    }

    public function testApplyWillNotSetValueIfMoreThanOneMarkLeft(): void
    {
        $grid = new Grid(2);
        $grid->getCell(new GridPosition(0, 0))->setMarks([1, 2]);
        $strategy = new SolveCellWhenSingleMarkLeft();
        $strategy->apply($grid);
        $this->assertTrue($grid->getCell(new GridPosition(0, 0))->isEmpty());
        $this->assertEquals([1, 2], $grid->getCell(new GridPosition(0, 0))->getMarks());
    }
}
