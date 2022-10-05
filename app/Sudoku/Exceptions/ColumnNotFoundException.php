<?php

namespace App\Sudoku\Exceptions;

use App\Sudoku\Models\Grid;
use Exception;

class ColumnNotFoundException extends Exception
{
    private int $column;
    private Grid $grid;

    /**
     * @param int $column
     * @param Grid $grid
     */
    public function __construct(int $column, Grid $grid)
    {
        parent::__construct('Column not found in Sudoku grid');
        $this->column = $column;
        $this->grid = $grid;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @return Grid
     */
    public function getGrid(): Grid
    {
        return $this->grid;
    }
}
