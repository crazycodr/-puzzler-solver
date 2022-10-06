<?php

namespace Tests\Sudoku\Activities;

use App\Sudoku\Activities\SetMarksOnCellActivity;
use PHPUnit\Framework\TestCase;

class AddMarksToCellActivityTest extends TestCase
{
    public function testColumnIsPersistedAndAccessible(): void
    {
        $activity = new SetMarksOnCellActivity(7, 9, [1, 2, 5, 8]);
        $this->assertEquals(7, $activity->getColumn());
    }

    public function testRowIsPersistedAndAccessible(): void
    {
        $activity = new SetMarksOnCellActivity(7, 9, [1, 2, 5, 8]);
        $this->assertEquals(9, $activity->getRow());
    }

    public function testMarksArePersistedAndAccessible(): void
    {
        $activity = new SetMarksOnCellActivity(7, 9, [1, 2, 5, 8]);
        $this->assertEquals([1,2,5,8], $activity->getMarks());
    }
}
