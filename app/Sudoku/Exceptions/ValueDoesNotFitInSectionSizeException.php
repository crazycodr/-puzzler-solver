<?php

namespace App\Sudoku\Exceptions;

use Exception;

class ValueDoesNotFitInSectionSizeException extends Exception
{
    private int $value;
    private int $maximumValue;

    public function __construct(int $value, int $maximumValue)
    {
        parent::__construct('Value does not fit in the section');
        $this->value = $value;
        $this->maximumValue = $maximumValue;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getMaximumValue(): int
    {
        return $this->maximumValue;
    }
}
