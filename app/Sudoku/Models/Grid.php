<?php

namespace App\Sudoku\Models;

use App\Sudoku\Exceptions\ColumnNotFoundException;
use App\Sudoku\Exceptions\NonEquivalentColumnsPerSectionException;
use App\Sudoku\Exceptions\NonEquivalentRowsPerSectionException;
use App\Sudoku\Exceptions\RowNotFoundException;
use App\Sudoku\Exceptions\ValueDoesNotFitInSectionSizeException;

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
        $this->validateColumnsPerSectionIsValid();
        $this->validateRowsPerSectionIsValid();
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
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function setValue(int $column, int $row, ?int $value): void
    {
        if (!array_key_exists($column, $this->values)) {
            throw new ColumnNotFoundException($column, $this);
        }
        if (!array_key_exists($row, $this->values[$column])) {
            throw new RowNotFoundException($row, $this);
        }
        if ($value !== null) {
            $maximumValue = $this->getColumnsPerSection() * $this->getRowsPerSection();
            if ($value < 1 || $value > $maximumValue) {
                throw new ValueDoesNotFitInSectionSizeException($value, $maximumValue);
            }
        }
        $this->values[$column][$row] = $value;
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
        return array_values($this->marks[$column][$row]);
    }

    /**
     * @throws ColumnNotFoundException
     * @throws RowNotFoundException
     * @throws ValueDoesNotFitInSectionSizeException
     */
    public function setMarks(int $column, int $row, array $marks): void
    {
        if (!array_key_exists($column, $this->values)) {
            throw new ColumnNotFoundException($column, $this);
        }
        if (!array_key_exists($row, $this->values[$column])) {
            throw new RowNotFoundException($row, $this);
        }
        $minimumMark = min($marks);
        $maximumMark = max($marks);
        $maximumValue = $this->getColumnsPerSection() * $this->getRowsPerSection();
        if ($minimumMark < 1) {
            throw new ValueDoesNotFitInSectionSizeException($minimumMark, $maximumValue);
        }
        if ($maximumMark > $maximumValue) {
            throw new ValueDoesNotFitInSectionSizeException($maximumMark, $maximumValue);
        }
        $this->marks[$column][$row] = $marks;
    }

    /**
     * @return void
     * @throws NonEquivalentColumnsPerSectionException
     */
    public function validateColumnsPerSectionIsValid(): void
    {
        $columnSections = $this->getColumns() / $this->getColumnsPerSection();
        if ($columnSections != floor($columnSections)) {
            throw new NonEquivalentColumnsPerSectionException($this->getColumns(), $this->getColumnsPerSection());
        }
    }

    /**
     * @return void
     * @throws NonEquivalentRowsPerSectionException
     */
    public function validateRowsPerSectionIsValid(): void
    {
        $rowSections = $this->getRows() / $this->getRowsPerSection();
        if (($rowSections) != floor($rowSections)) {
            throw new NonEquivalentRowsPerSectionException($this->getRows(), $this->getRowsPerSection());
        }
    }
}
