<?php

namespace App\Sudoku\Strategies;

use App\Sudoku\Activities\ActivityInterface;
use App\Sudoku\Activities\SetMarksOnCellActivity;
use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\RowNotFoundException;
use App\Sudoku\Exceptions\ValueDoesNotFitInSectionSizeException;
use App\Sudoku\Factories\ZoneFactory;
use App\Sudoku\Models\Grid;

class AddMarkBasedOnRowAndColumnValuesRelativeToCell
{

    private ZoneFactory $zoneFactory;

    public function __construct(ZoneFactory $zoneFactory)
    {
        $this->zoneFactory = $zoneFactory;
    }

    /**
     * @param Grid $grid
     * @param int $column
     * @param int $row
     * @return ?ActivityInterface
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function applyOnCell(Grid $grid, int $column, int $row): ?ActivityInterface
    {
        $value = $grid->getValue($column, $row);
        if ($value) {
            return null;
        }

        $marks = $grid->getMarks($column, $row);
        if (!empty($marks)) {
            return null;
        }

        $columnZone = $this->zoneFactory->createFromGridForColumn($grid, $column);
        $rowZone = $this->zoneFactory->createFromGridForRow($grid, $row);
        $sectionZone = $this->zoneFactory->createFromGridForSectionContainingCell($grid, $column, $row);

        $uniqueColumnValues = $columnZone->getUniqueValuesFromGrid($grid);
        $uniqueRowValues = $rowZone->getUniqueValuesFromGrid($grid);
        $uniqueSectionValues = $sectionZone->getUniqueValuesFromGrid($grid);

        $gridValues = range(1, $grid->getRows());
        $possibleValues = array_values(array_diff($gridValues, $uniqueColumnValues, $uniqueRowValues, $uniqueSectionValues));

        $grid->setMarks($column, $row, $possibleValues);
        return new SetMarksOnCellActivity($column, $row, $possibleValues);
    }

}
