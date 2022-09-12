<?php

namespace Tests\Unit\Models\CrossSums\Validators;

use App\CrossSums\RiddleSnapshot;
use App\CrossSums\Validators\CompareRiddleCellsValidator;
use App\CrossSums\Validators\InvalidCellIndexException;
use PHPUnit\Framework\TestCase;

class CompareRiddleCellsValidatorTest extends TestCase
{

    public function testValidateThrowsExceptionWhenHorizontalIndexIsInvalid(): void
    {
        $this->expectException(InvalidCellIndexException::class);
        $validator = new CompareRiddleCellsValidator();
        $mockedRiddle = $this->createMock(RiddleSnapshot::class);
        $validator->validate($mockedRiddle, $mockedRiddle, -1, 0);
    }

    public function testValidateThrowsExceptionWhenHorizontalIndexIsInvalid2(): void
    {
        $this->expectException(InvalidCellIndexException::class);
        $validator = new CompareRiddleCellsValidator();
        $mockedRiddle = $this->createMock(RiddleSnapshot::class);
        $validator->validate($mockedRiddle, $mockedRiddle, 9, 0);
    }

    public function testValidateThrowsExceptionWhenVerticalIndexIsInvalid(): void
    {
        $this->expectException(InvalidCellIndexException::class);
        $validator = new CompareRiddleCellsValidator();
        $mockedRiddle = $this->createMock(RiddleSnapshot::class);
        $validator->validate($mockedRiddle, $mockedRiddle, 0, -1);
    }

    public function testValidateThrowsExceptionWhenVerticalIndexIsInvalid2(): void
    {
        $this->expectException(InvalidCellIndexException::class);
        $validator = new CompareRiddleCellsValidator();
        $mockedRiddle = $this->createMock(RiddleSnapshot::class);
        $validator->validate($mockedRiddle, $mockedRiddle, 0, 9);
    }

    /**
     * @throws InvalidCellIndexException
     */
    public function testValidateReturnsFalseWhenSpecifiedValuesAreDifferent(): void
    {
        $validator = new CompareRiddleCellsValidator();
        $mockedHorizontalRiddle = $this->createMock(RiddleSnapshot::class);
        $mockedHorizontalRiddle->method('getOperand1')->willReturn(1);
        $mockedVerticalRiddle = $this->createMock(RiddleSnapshot::class);
        $mockedVerticalRiddle->method('getOperand2')->willReturn(2);
        $result = $validator->validate($mockedHorizontalRiddle, $mockedVerticalRiddle, 0, 1);
        $this->assertFalse($result);
    }

    /**
     * @throws InvalidCellIndexException
     */
    public function testValidateReturnsTrueWhenSpecifiedValuesAreSame(): void
    {
        $validator = new CompareRiddleCellsValidator();
        $mockedHorizontalRiddle = $this->createMock(RiddleSnapshot::class);
        $mockedHorizontalRiddle->method('getOperand2')->willReturn(1);
        $mockedVerticalRiddle = $this->createMock(RiddleSnapshot::class);
        $mockedVerticalRiddle->method('getOperand3')->willReturn(1);
        $result = $validator->validate($mockedHorizontalRiddle, $mockedVerticalRiddle, 1, 2);
        $this->assertTrue($result);
    }
}
