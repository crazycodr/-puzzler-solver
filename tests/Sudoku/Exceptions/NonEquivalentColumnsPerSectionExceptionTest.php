<?php

namespace Tests\Sudoku\Exceptions;

use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use PHPUnit\Framework\TestCase;

class NonEquivalentColumnsPerSectionExceptionTest extends TestCase
{
    public function testColumnsIsPreservedAndAccessible(): void
    {
        $object = new NonEquivalentColumnsPerSectionException(99, 77);
        $this->assertEquals(99, $object->getColumns());
    }

    public function testColumnsPerSectionIsPreservedAndAccessible(): void
    {
        $object = new NonEquivalentColumnsPerSectionException(99, 77);
        $this->assertSame(77, $object->getColumnsPerSection());
    }
}
