<?php

namespace App\Sudoku\Models;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\RowNotFoundException;

class Zone
{

    private int $startColumn;
    private int $endColumn;
    private int $startRow;
    private int $endRow;

    public function __construct(int $columnStart, int $columnEnd, int $rowStart, int $rowEnd)
    {
        $this->startColumn = $columnStart;
        $this->endColumn = $columnEnd;
        $this->startRow = $rowStart;
        $this->endRow = $rowEnd;
    }

    /**
     * @return int
     */
    public function getStartColumn(): int
    {
        return $this->startColumn;
    }

    /**
     * @return int
     */
    public function getEndColumn(): int
    {
        return $this->endColumn;
    }

    /**
     * @return int
     */
    public function getStartRow(): int
    {
        return $this->startRow;
    }

    /**
     * @return int
     */
    public function getEndRow(): int
    {
        return $this->endRow;
    }

    /**
     * @param Grid $grid
     * @return int[]
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function getUniqueValuesFromGrid(Grid $grid): array
    {
        $values = [];
        for ($iColumn = $this->getStartColumn(); $iColumn <= $this->getEndColumn(); $iColumn++) {
            for ($iRow = $this->getStartRow(); $iRow <= $this->getEndRow(); $iRow++) {
                $value = $grid->getValue($iColumn, $iRow);
                if ($value) {
                    $values[] = $value;
                }
            }
        }
        return array_unique($values);
    }

}
