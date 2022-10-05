<?php

namespace App\Sudoku\Models;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use App\Sudoku\Exceptions\RowNotFoundException;

class Grid
{

    private int $columns;
    private int $rows;
    private int $rowsPerSection;
    private int $columnsPerSection;
    private array $values = [];
    private array $marks = [];

    /**
     * @throws NonEquivalentRowsPerSectionException
     * @throws NonEquivalentColumnsPerSectionException
     */
    public function __construct(int $columns, int $rows, int $columnsPerSection, int $rowsPerSection)
    {
        $this->columns = $columns;
        $this->rows = $rows;
        $this->columnsPerSection = $columnsPerSection;
        $this->rowsPerSection = $rowsPerSection;
        if (($this->getColumns() / $this->getColumnsPerSection()) !== floor($this->getColumns() / $this->getColumnsPerSection())) {
            throw new NonEquivalentColumnsPerSectionException($this->getColumns(), $this->getColumnsPerSection());
        }
        if (($this->getRows() / $this->getRowsPerSection()) !== floor($this->getRows() / $this->getRowsPerSection())) {
            throw new NonEquivalentRowsPerSectionException($this->getRows(), $this->getRowsPerSection());
        }
        $this->initializeValues();
        $this->initializeMarks();
    }

    /**
     * @return int
     */
    public function getColumns(): int
    {
        return $this->columns;
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
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function getRowsPerSection(): int
    {
        return $this->rowsPerSection;
    }

    /**
     * @return void
     */
    public function initializeValues(): void
    {
        for ($iColumn = 1; $iColumn <= $this->getColumns(); $iColumn++) {
            for ($iRow = 1; $iRow <= $this->getRows(); $iRow++) {
                $this->values[$iColumn][$iRow] = null;
            }
        }
    }

    /**
     * @return void
     */
    public function initializeMarks(): void
    {
        for ($iColumn = 1; $iColumn <= $this->getColumns(); $iColumn++) {
            for ($iRow = 1; $iRow <= $this->getRows(); $iRow++) {
                $this->marks[$iColumn][$iRow] = [];
            }
        }
    }

    /**
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function getValue(int $column, int $row): ?int
    {
        if (!array_key_exists($column, $this->values)) {
            throw new ColumnNotFoundException($column, $this);
        }
        if (!array_key_exists($row, $this->values[$column])) {
            throw new RowNotFoundException($row, $this);
        }
        return $this->values[$column][$row];
    }

    /**
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     */
    public function getMarks(int $column, int $row): array
    {
        if (!array_key_exists($column, $this->values)) {
            throw new ColumnNotFoundException($column, $this);
        }
        if (!array_key_exists($row, $this->values[$column])) {
            throw new RowNotFoundException($row, $this);
        }
        return $this->marks[$column][$row];
    }
}
