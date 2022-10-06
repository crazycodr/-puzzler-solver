<?php

namespace Tests\Sudoku\Strategies;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use App\Sudoku\Exceptions\RowNotFoundException;
use App\Sudoku\Exceptions\ValueDoesNotFitInSectionSizeException;
use App\Sudoku\Factories\ZoneFactory;
use App\Sudoku\Models\Grid;
use App\Sudoku\Strategies\AddMarkBasedOnRowAndColumnValuesRelativeToCell;
use PHPUnit\Framework\TestCase;

class AddMarkBasedOnRowAndColumnValuesRelativeToCellTest extends TestCase
{
    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testNoValuesInColumnRowOrSectionApplyAllMarksOnCell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testValuesInColumnApplyLimitedMarksOnCell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setValue(1, 3, 1);
        $grid->setValue(1, 4, 2);
        $grid->setValue(1, 9, 7);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([3, 4, 5, 6, 8, 9], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testValuesInRowApplyLimitedMarksOnCell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setValue(2, 1, 2);
        $grid->setValue(8, 1, 4);
        $grid->setValue(9, 1, 6);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([1, 3, 5, 7, 8, 9], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testValuesInSectionApplyLimitedMarksOnCell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setValue(1, 2, 2);
        $grid->setValue(2, 2, 7);
        $grid->setValue(3, 3, 9);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([1, 3, 4, 5, 6, 8], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testValuesInDifferentColumnRowAndSectionApplyLimitedMarksOnCell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setValue(1, 2, 2);
        $grid->setValue(2, 2, 7);
        $grid->setValue(3, 3, 9);
        $grid->setValue(1, 7, 1);
        $grid->setValue(1, 9, 4);
        $grid->setValue(4, 1, 5);
        $grid->setValue(5, 1, 3);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([6, 8], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testMarksUnaffectedIfThereIsAValueInACell(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setValue(1, 1, 1);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([], $grid->getMarks(1, 1));
    }

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     * @throws ColumnNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     * @throws RowNotFoundException
     */
    public function testMarksUnaffectedIfThereAreAlreadyMarks(): void
    {
        $grid = new Grid(9, 9, 3, 3);
        $grid->setMarks(1, 1, [1]);
        $strategy = new AddMarkBasedOnRowAndColumnValuesRelativeToCell(new ZoneFactory());
        $strategy->applyOnCell($grid, 1, 1);
        $this->assertEquals([1], $grid->getMarks(1, 1));
    }
}
