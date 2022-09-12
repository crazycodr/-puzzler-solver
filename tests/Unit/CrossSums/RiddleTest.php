<?php

namespace Tests\Unit\CrossSums;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Riddle;
use PHPUnit\Framework\TestCase;

class RiddleTest extends TestCase
{

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleAcceptsAddOperationsAndReturnsItFromGetters(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $this->assertEquals(Riddle::OPERATOR_ADD, $riddle->getOperator1(), 'Operator 1 should have been a ADD');
        $this->assertEquals(Riddle::OPERATOR_ADD, $riddle->getOperator2(), 'Operator 2 should have been a ADD');
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleAcceptsSubOperationsAndReturnsItFromGetters(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_SUB, Riddle::OPERATOR_SUB, 0);
        $this->assertEquals(Riddle::OPERATOR_SUB, $riddle->getOperator1(), 'Operator 1 should have been a SUB');
        $this->assertEquals(Riddle::OPERATOR_SUB, $riddle->getOperator2(), 'Operator 2 should have been a SUB');
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleAcceptsMulOperationsAndReturnsItFromGetters(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_MUL, Riddle::OPERATOR_MUL, 0);
        $this->assertEquals(Riddle::OPERATOR_MUL, $riddle->getOperator1(), 'Operator 1 should have been a MUL');
        $this->assertEquals(Riddle::OPERATOR_MUL, $riddle->getOperator2(), 'Operator 2 should have been a MUL');
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleAcceptsDivOperationsAndReturnsItFromGetters(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_DIV, Riddle::OPERATOR_DIV, 0);
        $this->assertEquals(Riddle::OPERATOR_DIV, $riddle->getOperator1(), 'Operator 1 should have been a DIV');
        $this->assertEquals(Riddle::OPERATOR_DIV, $riddle->getOperator2(), 'Operator 2 should have been a DIV');
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleWillSaveDifferentOperatorsProperly(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_DIV, 0);
        $this->assertEquals(Riddle::OPERATOR_ADD, $riddle->getOperator1(), 'Operator 1 should have been a ADD');
        $this->assertEquals(Riddle::OPERATOR_DIV, $riddle->getOperator2(), 'Operator 2 should have been a DIV');
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleWillSaveExpectedResultProperly(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_DIV, 77);
        $this->assertEquals(77, $riddle->getExpectedResult(), 'Expected result should have been 77');
    }

    public function testRiddleThrowsExceptionIfNotPassingAValidOperator(): void
    {
        $this->expectException(InvalidOperatorException::class);
        new Riddle('@', Riddle::OPERATOR_DIV, 0);
    }
}
