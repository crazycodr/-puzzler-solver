<?php

namespace Tests\Unit\Futoshikis\Solvers\Strategies;

use App\Futoshikis\Models\Grid;
use App\Futoshikis\Models\GridPosition;
use App\Futoshikis\Models\Rule;
use App\Futoshikis\Solvers\Strategies\RemoveImpossibleMarksBasedOnRules;
use App\Futoshikis\Solvers\Strategies\SolveCellWhenMarkAloneInCol;
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

    public function testRegressionNotRemoving1And2In23When13HasOnly3AndRuleHintsItProperly(): void
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
        $grid->getCell(new GridPosition(2, 3))->setMarks([1,2,4]);
        $grid->getCell(new GridPosition(3, 3))->setMarks([1,2,4]);
        $grid->addRule(new Rule(new GridPosition(1,3), new GridPosition(2,3)));
        $strategy = new RemoveImpossibleMarksBasedOnRules();
        $strategy->apply($grid);
        $this->assertEquals([4], $grid->getCell(new GridPosition(2, 3))->getMarks());
    }
}
