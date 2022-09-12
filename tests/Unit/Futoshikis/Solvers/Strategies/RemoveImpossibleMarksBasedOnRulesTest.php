<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;
use App\Futoshikis\Solvers\Strategies\RemoveImpossibleMarksBasedOnRules;
use PHPUnit\Framework\TestCase;

class RemoveImpossibleMarksBasedOnRulesTest extends TestCase
{
    public function testRuleApplyingToCorrectMarkingsDontUpdateAnything(): void
    {
        $grid = new Grid(2);
        $grid->addRule(new Rule(
            new GridPosition(0,0),
            new GridPosition(0, 1)
        ));
        $grid->getCell(new GridPosition(0, 0))->setMarks([1]);
        $grid->getCell(new GridPosition(0, 1))->setMarks([2]);
        $strategy = new RemoveImpossibleMarksBasedOnRules();
        $strategy->apply($grid);
        $this->assertEquals([1], $grid->getCell(new GridPosition(0, 0))->getMarks());
        $this->assertEquals([2], $grid->getCell(new GridPosition(0, 1))->getMarks());
    }

    public function testRuleRemovesMarksTooHighInLesserCellWhenGreaterCellIsLessThanOrEqualToIt(): void
    {
        $grid = new Grid(2);
        $grid->addRule(new Rule(
            new GridPosition(0,0),
            new GridPosition(0, 1)
        ));
        $this->assertEquals([1,2], $grid->getCell(new GridPosition(0, 0))->getMarks());
        $this->assertEquals([1,2], $grid->getCell(new GridPosition(0, 1))->getMarks());
        $strategy = new RemoveImpossibleMarksBasedOnRules();
        $strategy->apply($grid);
        $this->assertEquals([1], $grid->getCell(new GridPosition(0, 0))->getMarks());
    }
}
