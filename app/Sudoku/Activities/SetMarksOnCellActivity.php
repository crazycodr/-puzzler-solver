<?php

namespace App\Sudoku\Activities;

class SetMarksOnCellActivity implements ActivityInterface
{

    private int $column;
    private int $row;
    private array $marks;

    public function __construct(int $column, int $row, array $marks)
    {
        $this->column = $column;
        $this->row = $row;
        $this->marks = $marks;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @return array
     */
    public function getMarks(): array
    {
        return $this->marks;
    }

    public function getOperator(): string
    {
        return self::OPERATOR_SET_MARKS;
    }

    public function getValue(): ?int
    {
        return null;
    }
}
