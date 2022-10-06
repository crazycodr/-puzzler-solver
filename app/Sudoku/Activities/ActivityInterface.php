<?php

namespace App\Sudoku\Activities;

interface ActivityInterface
{

    public const OPERATOR_SET_VALUE = 'set_value';
    public const OPERATOR_SET_MARKS = 'set_marks';
    public const OPERATOR_UNSET_MARK = 'unset_mark';

    /**
     * @return int
     */
    public function getColumn(): int;

    /**
     * @return int
     */
    public function getRow(): int;

    /**
     * @return string
     */
    public function getOperator(): string;

    /**
     * @return array
     */
    public function getMarks(): array;

    /**
     * @return ?int
     */
    public function getValue(): ?int;
}
