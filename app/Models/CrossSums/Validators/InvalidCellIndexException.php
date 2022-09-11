<?php

namespace App\Models\CrossSums\Validators;

use Exception;

class InvalidCellIndexException extends Exception
{
    public readonly string $direction;
    public readonly int $index;

    /**
     * @param string $direction
     * @param int $index
     */
    public function __construct(string $direction, int $index)
    {
        parent::__construct('Invalid cell index for direction');
        $this->direction = $direction;
        $this->index = $index;
    }
}
