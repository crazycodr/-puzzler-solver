<?php

namespace App\Sudoku\Factories;

use App\Sudoku\Models\Grid;
use App\Sudoku\Models\Zone;

class ZoneFactory
{

    public function createFromGridForColumn(Grid $grid, int $column): Zone
    {
        return new Zone($column, $column, 1, $grid->getRows());
    }

    public function createFromGridForRow(Grid $grid, int $row): Zone
    {
        return new Zone(1, $grid->getColumns(), $row, $row);
    }

    public function createFromGridForSectionContainingCell(Grid $grid, int $column, int $row): Zone
    {
        $columnSectionIndex = ceil($column / $grid->getColumnsPerSection());
        $rowSectionIndex = ceil($row / $grid->getRowsPerSection());
        $startColumn = ($columnSectionIndex - 1) * $grid->getColumnsPerSection() + 1;
        $endColumn = $columnSectionIndex * $grid->getColumnsPerSection();
        $startRow = ($rowSectionIndex - 1) * $grid->getRowsPerSection() + 1;
        $endRow = $rowSectionIndex * $grid->getRowsPerSection();
        return new Zone($startColumn, $endColumn, $startRow, $endRow);
    }

}
