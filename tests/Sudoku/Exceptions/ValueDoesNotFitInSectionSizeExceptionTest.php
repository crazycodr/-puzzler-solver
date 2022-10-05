<?php

namespace Tests\Sudoku\Exceptions;

use App\Sudoku\Exceptions\ValueDoesNotFitInSectionSizeException;
use PHPUnit\Framework\TestCase;

class ValueDoesNotFitInSectionSizeExceptionTest extends TestCase
{
    public function testValueIsPreservedAndAccessible(): void
    {
        $object = new ValueDoesNotFitInSectionSizeException(99, 9);
        $this->assertEquals(99, $object->getValue());
    }

    public function testMaximumValueIsPreservedAndAccessible(): void
    {
        $object = new ValueDoesNotFitInSectionSizeException(99, 9);
        $this->assertSame(9, $object->getMaximumValue());
    }
}
