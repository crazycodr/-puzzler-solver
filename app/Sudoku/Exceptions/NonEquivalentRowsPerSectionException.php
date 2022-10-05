<?php

namespace App\Sudoku\Exceptions;

use Exception;

class NonEquivalentRowsPerSectionException extends Exception
{
    private int $rows;
    private int $rowsPerSection;

    /**
     * @param int $rows
     * @param int $rowsPerSection
     */
    public function __construct(int $rows, int $rowsPerSection)
    {
        parent::__construct('Rows per section invalid because you cannot evenly divide rows in sections');
        $this->rows = $rows;
        $this->rowsPerSection = $rowsPerSection;
    }

    /**
     * @return int
     */
    public function getRowsPerSection(): int
    {
        return $this->rowsPerSection;
    }

    /**
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }
}
