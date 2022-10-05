<?php

namespace Tests\Sudoku\Exceptions;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Models\Grid;
use PHPUnit\Framework\TestCase;

class ColumnNotFoundExceptionTest extends TestCase
{
    public function testColumnIsPreservedAndAccessible(): void
    {
        $grid = $this->getMockBuilder(Grid::class)->disableOriginalConstructor()->getMock();
        $object = new ColumnNotFoundException(99, $grid);
        $this->assertEquals(99, $object->getColumn());
    }

    public function testGridIsPreservedAndAccessible(): void
    {
        $grid = $this->getMockBuilder(Grid::class)->disableOriginalConstructor()->getMock();
        $object = new ColumnNotFoundException(99, $grid);
        $this->assertSame($grid, $object->getGrid());
    }
}
