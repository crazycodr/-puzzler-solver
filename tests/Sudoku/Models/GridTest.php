<?php

namespace Tests\Sudoku\Models;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use App\Sudoku\Exceptions\RowNotFoundException;
use App\Sudoku\Exceptions\ValueDoesNotFitInSectionSizeException;
use App\Sudoku\Models\Grid;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testColumnsIsPersistedAndAccessible(): void
    {
        $grid = new Grid(9, 6, 3, 2);
        $this->assertEquals(9, $grid->getColumns());
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testRowsIsPersistedAndAccessible(): void
    {
        $grid = new Grid(9, 6, 3, 2);
        $this->assertEquals(6, $grid->getRows());
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testColumnsPerSectionIsPersistedAndAccessible(): void
    {
        $grid = new Grid(9, 6, 3, 2);
        $this->assertEquals(3, $grid->getColumnsPerSection());
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testRowsPerSectionIsPersistedAndAccessible(): void
    {
        $grid = new Grid(9, 6, 3, 2);
        $this->assertEquals(2, $grid->getRowsPerSection());
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testColumnsPerSectionNotEvenlyDividedThrowsException(): void
    {
        $this->expectException(NonEquivalentColumnsPerSectionException::class);
        new Grid(9, 6, 2, 2);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function testRowsPerSectionNotEvenlyDividedThrowsException(): void
    {
        $this->expectException(NonEquivalentRowsPerSectionException::class);
        new Grid(9, 6, 3, 4);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testValuesAllInitializedToNull(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        for ($iColumn = 1; $iColumn <= 6; $iColumn++) {
            for ($iRow = 1; $iRow <= 6; $iRow++) {
                $this->assertNull($grid->getValue($iColumn, $iRow));
            }
        }
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testValuesAllMarksInitializedToEmptyArray(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        for ($iColumn = 1; $iColumn <= 6; $iColumn++) {
            for ($iRow = 1; $iRow <= 6; $iRow++) {
                $this->assertEquals([], $grid->getMarks($iColumn, $iRow));
            }
        }
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testGetValueWillThrowColumnNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ColumnNotFoundException::class);
        $grid->getValue(99, 1);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testGetValueWillThrowRowNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(RowNotFoundException::class);
        $grid->getValue(1, 99);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testGetMarksWillThrowColumnNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ColumnNotFoundException::class);
        $grid->getMarks(99, 1);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function testGetMarksWillThrowRowNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(RowNotFoundException::class);
        $grid->getMarks(1, 99);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetValueWillThrowColumnNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ColumnNotFoundException::class);
        $grid->setValue(99, 1, 1);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetValueWillThrowRowNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(RowNotFoundException::class);
        $grid->setValue(1, 99, 1);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetValueWillThrowValueDoesNotFitInSectionSizeExceptionWhenValueIsTooLarge(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ValueDoesNotFitInSectionSizeException::class);
        $grid->setValue(1, 1, 3 * 2 + 1);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetValuePersistsValue(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $grid->setValue(1, 1, 5);
        $this->assertEquals(5, $grid->getValue(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetNullValuePersistsValueOverExisting(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $grid->setValue(1, 1, 5);
        $grid->setValue(1, 1, null);
        $this->assertNull($grid->getValue(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetMarksWillThrowColumnNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ColumnNotFoundException::class);
        $grid->setMarks(99, 1, [1, 2, 3]);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetMarksWillThrowRowNotFoundExceptionWhenApplicable(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(RowNotFoundException::class);
        $grid->setMarks(1, 99, [1, 2, 3]);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetMarksWillThrowValueDoesNotFitInSectionSizeExceptionWhenMarksIsTooLow(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ValueDoesNotFitInSectionSizeException::class);
        $grid->setMarks(1, 1, [-1, 2, 3]);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetMarksWillThrowValueDoesNotFitInSectionSizeExceptionWhenMarksIsTooLarge(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $this->expectException(ValueDoesNotFitInSectionSizeException::class);
        $grid->setMarks(1, 1, [1, 2, 99]);
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function testSetMarksPersistsMarks(): void
    {
        $grid = new Grid(6, 6, 3, 2);
        $grid->setMarks(1, 1, [1, 2, 3]);
        $this->assertEquals([1, 2, 3], $grid->getMarks(1, 1));
    }
}
