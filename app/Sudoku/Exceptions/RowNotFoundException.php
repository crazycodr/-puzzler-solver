<?php

namespace App\Sudoku\Exceptions;

use App\Sudoku\Models\Grid;
use Exception;

class RowNotFoundException extends Exception
{
    private int $row;
    private Grid $grid;

    /**
     * @param int $row
     * @param Grid $grid
     */
    public function __construct(int $row, Grid $grid)
    {
        parent::__construct('Row not found in Sudoku grid');
        $this->row = $row;
        $this->grid = $grid;
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @return Grid
     */
    public function getGrid(): Grid
    {
        return $this->grid;
    }
}
