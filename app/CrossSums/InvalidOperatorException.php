<?php

namespace App\CrossSums;

use Exception;

class InvalidOperatorException extends Exception
{

    /**
     * @param string $operator
     */
    public function __construct(string $operator)
    {
        $allowedOperators = [
            Riddle::OPERATOR_ADD,
            Riddle::OPERATOR_SUB,
            Riddle::OPERATOR_MUL,
            Riddle::OPERATOR_DIV,
        ];
        parent::__construct($operator . ' is not a valid operator, only ' . implode(', ', $allowedOperators));
    }
}
