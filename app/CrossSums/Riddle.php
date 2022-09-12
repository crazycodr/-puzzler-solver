<?php

namespace App\CrossSums;

class Riddle
{

    public const OPERATOR_ADD = '+';
    public const OPERATOR_SUB = '-';
    public const OPERATOR_MUL = '*';
    public const OPERATOR_DIV = '/';

    /**
     * @var string
     */
    private string $operator1;

    /**
     * @var string
     */
    private string $operator2;

    /**
     * @var int
     */
    private int $expectedResult;

    /**
     * @throws InvalidOperatorException
     */
    public function __construct(string $operator1, string $operator2, int $expectedResult)
    {
        $this->operator1 = $this->assertAndReturnOperator($operator1);
        $this->operator2 = $this->assertAndReturnOperator($operator2);
        $this->expectedResult = $expectedResult;
    }

    /**
     * @return string
     */
    public function getOperator1(): string
    {
        return $this->operator1;
    }

    /**
     * @return string
     */
    public function getOperator2(): string
    {
        return $this->operator2;
    }

    /**
     * @return int
     */
    public function getExpectedResult(): int
    {
        return $this->expectedResult;
    }

    /**
     * @throws InvalidOperatorException
     */
    private function assertAndReturnOperator(string $operator): string
    {
        if ($operator === self::OPERATOR_ADD) {
            return $operator;
        }
        if ($operator === self::OPERATOR_SUB) {
            return $operator;
        }
        if ($operator === self::OPERATOR_MUL) {
            return $operator;
        }
        if ($operator === self::OPERATOR_DIV) {
            return $operator;
        }
        throw new InvalidOperatorException($operator);
    }

}
