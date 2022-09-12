<?php

namespace Tests\Unit\CrossSums;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Riddle;
use App\CrossSums\RiddleSnapshot;
use PHPUnit\Framework\TestCase;

class RiddleSnapshotTest extends TestCase
{
    /**
     * @throws InvalidOperatorException
     */
    public function testSnapshotWillSaveOperandsAndRiddleProperlyAndGettersWillReturnExpectedInformation(): void
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_SUB, 55);
        $snapshot = new RiddleSnapshot(22, 33, 44, $riddle);
        $this->assertEquals(22, $snapshot->getOperand1(), 'Operand 1 should have been 22');
        $this->assertEquals(33, $snapshot->getOperand2(), 'Operand 2 should have been 33');
        $this->assertEquals(44, $snapshot->getOperand3(), 'Operand 3 should have been 44');
        $this->assertSame($riddle, $snapshot->getRiddle(), 'Riddle is not expected object');
    }

    /**
     * @dataProvider providesCalculateResultWillApplyOperatorAndOperandsProperlyTogether
     * @param int $operand1
     * @param string $operator1
     * @param int $operand2
     * @param string $operator2
     * @param int $operand3
     * @param int $expectedResult
     * @return void
     * @throws InvalidOperatorException
     */
    public function testCalculateResultWillApplyOperatorAndOperandsProperlyTogether(int $operand1, string $operator1, int $operand2, string $operator2, int $operand3, int $expectedResult): void
    {
        $riddle = new Riddle($operator1, $operator2, $expectedResult);
        $snapshot = new RiddleSnapshot($operand1, $operand2, $operand3, $riddle);
        $this->assertEquals($riddle->getExpectedResult(), $snapshot->calculateResult());
    }

    public function providesCalculateResultWillApplyOperatorAndOperandsProperlyTogether(): array
    {
        $riddles = [
            '1 + 2 + 3 = 6',
            '2 + 3 + 4 = 9',
            '8 - 2 + 1 = 7',
            '3 + 1 - 2 = 2',
            '6 - 2 - 1 = 3',
            '5 + 4 - 8 = 1',
            '8 * 2 + 1 = 17',
            '8 * 2 * 3 = 48',
            '8 + 2 * 2 = 20',
            '8 - 4 * 3 = 12',
            '8 * 4 - 9 = 23',
            '8 / 2 + 1 = 5',
            '8 / 2 / 2 = 2',
            '8 + 2 / 2 = 5',
            '8 - 4 / 4 = 1',
            '8 / 4 - 1 = 1',
        ];
        $providerTestCases = [];
        foreach ($riddles as $riddle) {
            list($operand1, $operator1, $operand2, $operator2, $operand3, $uselessEqualSign, $expectedResult) = explode(' ', $riddle);
            $providerTestCases[$riddle] = [
                'operand1' => (int)$operand1,
                'operator1' => $operator1,
                'operand2' => (int)$operand2,
                'operator2' => $operator2,
                'operand3' => (int)$operand3,
                'expectedResult' => (int)$expectedResult,
            ];
            unset($uselessEqualSign);
        }
        return $providerTestCases;
    }

    /**
     * @return void
     * @throws InvalidOperatorException
     */
    public function testCalculateResultWillThrowExceptionIfOperatorIsInvalid(): void
    {
        $riddle = $this->createMock(Riddle::class);
        $riddle->method('getOperator1')->willReturn('@');
        $riddle->method('getOperator2')->willReturn('@');
        $snapshot = new RiddleSnapshot(1, 1, 1, $riddle);
        $this->expectException(InvalidOperatorException::class);
        $snapshot->calculateResult();
    }

    /**
     * @return void
     */
    public function testIsResultExpectedSilencesInvalidOperatorExceptionAndReturnsFalse(): void
    {
        $riddle = $this->createMock(Riddle::class);
        $riddle->method('getOperator1')->willReturn('@');
        $riddle->method('getOperator2')->willReturn('@');
        $snapshot = new RiddleSnapshot(1, 1, 1, $riddle);
        $this->assertFalse($snapshot->isResultExpected());
    }
}
