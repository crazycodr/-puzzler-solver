<?php

namespace Tests\Sudoku\Exceptions;

use App\Sudoku\Exceptions\RowNotFoundException;
use App\Sudoku\Models\Grid;
use PHPUnit\Framework\TestCase;

class RowNotFoundExceptionTest extends TestCase
{
    public function testRowIsPreservedAndAccessible(): void
    {
        $grid = $this->getMockBuilder(Grid::class)->disableOriginalConstructor()->getMock();
        $object = new RowNotFoundException(99, $grid);
        $this->assertEquals(99, $object->getRow());
    }

    public function testGridIsPreservedAndAccessible(): void
    {
        $grid = $this->getMockBuilder(Grid::class)->disableOriginalConstructor()->getMock();
        $object = new RowNotFoundException(99, $grid);
        $this->assertSame($grid, $object->getGrid());
    }
}
