<?php

namespace Tests\Sudoku\Exceptions;

use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use PHPUnit\Framework\TestCase;

class NonEquivalentRowsPerSectionExceptionTest extends TestCase
{
    public function testRowsIsPreservedAndAccessible(): void
    {
        $object = new NonEquivalentRowsPerSectionException(99, 77);
        $this->assertEquals(99, $object->getRows());
    }

    public function testRowsPerSectionIsPreservedAndAccessible(): void
    {
        $object = new NonEquivalentRowsPerSectionException(99, 77);
        $this->assertSame(77, $object->getRowsPerSection());
    }
}
