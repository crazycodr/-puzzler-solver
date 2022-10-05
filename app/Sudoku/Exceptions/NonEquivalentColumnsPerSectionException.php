<?php

namespace App\Sudoku\Exceptions;

use Exception;

class NonEquivalentColumnsPerSectionException extends Exception
{
    private int $columns;
    private int $columnsPerSection;

    /**
     * @param int $columns
     * @param int $columnsPerSection
     */
    public function __construct(int $columns, int $columnsPerSection)
    {
        parent::__construct('Columns per section invalid because you cannot evenly divide columns in sections');
        $this->columns = $columns;
        $this->columnsPerSection = $columnsPerSection;
    }

    /**
     * @return int
     */
    public function getColumnsPerSection(): int
    {
        return $this->columnsPerSection;
    }

    /**
     * @return int
     */
    public function getColumns(): int
    {
        return $this->columns;
    }
}
