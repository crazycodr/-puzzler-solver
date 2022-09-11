<?php

namespace App\Models\CrossSums;

class RiddleSnapshot
{

    public const OPERATOR_ADD = '+';
    public const OPERATOR_SUB = '-';
    public const OPERATOR_MUL = '*';
    public const OPERATOR_DIV = '/';

    /**
     * @var int
     */
    private int $operand1;

    /**
     * @var int
     */
    private int $operand2;

    /**
     * @var int
     */
    private int $operand3;

    /**
     * @var Riddle
     */
    private Riddle $riddle;

    public function __construct(int $operand1, int $operand2, int $operand3, Riddle $riddle)
    {
        $this->operand1 = $operand1;
        $this->operand2 = $operand2;
        $this->operand3 = $operand3;
        $this->riddle = $riddle;
    }

    /**
     * @return int
     */
    public function getOperand1(): int
    {
        return $this->operand1;
    }

    /**
     * @return int
     */
    public function getOperand2(): int
    {
        return $this->operand2;
    }

    /**
     * @return int
     */
    public function getOperand3(): int
    {
        return $this->operand3;
    }

    /**
     * @return Riddle
     */
    public function getRiddle(): Riddle
    {
        return $this->riddle;
    }

    /**
     * @throws InvalidOperatorException
     */
    public function calculateResult(): int
    {
        $combinedOperator1And2 = $this->applyOperator($this->getOperand1(), $this->getOperand2(), $this->getRiddle()->getOperator1());
        return $this->applyOperator($combinedOperator1And2, $this->getOperand3(), $this->getRiddle()->getOperator2());
    }

    public function isResultExpected(): bool
    {
        try {
            return $this->getRiddle()->getExpectedResult() === $this->calculateResult();
        } catch (InvalidOperatorException) {
            return false;
        }
    }

    /**
     * @throws InvalidOperatorException
     */
    private function applyOperator(int $operand1, int $operand2, string $operator): int
    {
        if ($operator === self::OPERATOR_ADD) {
            return $operand1 + $operand2;
        }
        if ($operator === self::OPERATOR_SUB) {
            return $operand1 - $operand2;
        }
        if ($operator === self::OPERATOR_MUL) {
            return $operand1 * $operand2;
        }
        if ($operator === self::OPERATOR_DIV) {
            return (int)($operand1 / $operand2);
        }
        throw new InvalidOperatorException($operator);
    }

}
