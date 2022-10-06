<?php

namespace Tests\Sudoku\Factories;

use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use App\Sudoku\Factories\ZoneFactory;
use App\Sudoku\Models\Grid;
use PHPUnit\Framework\TestCase;

class ZoneFactoryTest extends TestCase
{
    private Grid $grid;

    /**
     * @throws NonEquivalentColumnsPerSectionException
     * @throws NonEquivalentRowsPerSectionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->grid = new Grid(6, 6, 3, 2);
    }

    public function testCreateFromGridForColumnReturnsZoneWithColumn3Only(): void
    {
        $factory = new ZoneFactory();
        $zone = $factory->createFromGridForColumn($this->grid, 3);
        $this->assertEquals(3, $zone->getStartColumn());
        $this->assertEquals(3, $zone->getEndColumn());
    }

    public function testCreateFromGridForColumnReturnsZoneWithRowsFrom1ToMaxRow(): void
    {
        $factory = new ZoneFactory();
        $zone = $factory->createFromGridForColumn($this->grid, 3);
        $this->assertEquals(1, $zone->getStartRow());
        $this->assertEquals($this->grid->getRows(), $zone->getEndRow());
    }

    public function testCreateFromGridForRowReturnsZoneWithRow2Only(): void
    {
        $factory = new ZoneFactory();
        $zone = $factory->createFromGridForRow($this->grid, 2);
        $this->assertEquals(2, $zone->getStartRow());
        $this->assertEquals(2, $zone->getEndRow());
    }

    public function testCreateFromGridForRowReturnsZoneWithColumnsFrom1ToMaxColumn(): void
    {
        $factory = new ZoneFactory();
        $zone = $factory->createFromGridForRow($this->grid, 2);
        $this->assertEquals(1, $zone->getStartColumn());
        $this->assertEquals($this->grid->getColumns(), $zone->getEndColumn());
    }

    /**
     * @dataProvider providesCreateFromGridForSectionContainingCellReturnsProperColumnsAndRows
     * @param int $column
     * @param int $row
     * @param int $expectedStartColumn
     * @param int $expectedEndColumn
     * @param int $expectedStartRow
     * @param int $expectedEndRow
     */
    public function testCreateFromGridForSectionContainingCellReturnsProperColumnsAndRows(int $column, int $row, int $expectedStartColumn, int $expectedEndColumn, int $expectedStartRow, int $expectedEndRow): void
    {
        $factory = new ZoneFactory();
        $zone = $factory->createFromGridForSectionContainingCell($this->grid, $column, $row);
        $this->assertEquals($expectedStartColumn, $zone->getStartColumn());
        $this->assertEquals($expectedEndColumn, $zone->getEndColumn());
        $this->assertEquals($expectedStartRow, $zone->getStartRow());
        $this->assertEquals($expectedEndRow, $zone->getEndRow());
    }

    public function providesCreateFromGridForSectionContainingCellReturnsProperColumnsAndRows(): array
    {
        return [
            '1-1-is-section-1-1' => [1, 1, 1, 3, 1, 2],
            '1-3-is-section-1-2' => [1, 3, 1, 3, 3, 4],
            '1-6-is-section-1-3' => [1, 6, 1, 3, 5, 6],
            '5-1-is-section-2-1' => [5, 1, 4, 6, 1, 2],
            '5-3-is-section-2-2' => [5, 3, 4, 6, 3, 4],
            '5-6-is-section-2-3' => [5, 6, 4, 6, 5, 6],
        ];
    }
}
