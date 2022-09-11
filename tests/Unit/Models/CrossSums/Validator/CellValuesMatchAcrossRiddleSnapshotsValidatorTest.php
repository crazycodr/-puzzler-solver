<?php

namespace Tests\Unit\Models\CrossSums\Validator;

use App\Models\CrossSums\PuzzleSnapshot;
use App\Models\CrossSums\RiddleSnapshot;
use App\Models\CrossSums\Validators\CellValuesMatchAcrossRiddleSnapshotsValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CellValuesMatchAcrossRiddleSnapshotsValidatorTest extends TestCase
{

    public function testValidateReturnsTrueIfAllCellValuesMatch(): void
    {
        $validator = new CellValuesMatchAcrossRiddleSnapshotsValidator();
        $topSnapshot = $this->getRiddleSnapshotMock(1, 2, 3);
        $middleSnapshot = $this->getRiddleSnapshotMock(1, 2, 3);
        $bottomSnapshot = $this->getRiddleSnapshotMock(1, 2, 3);
        $leftSnapshot = $this->getRiddleSnapshotMock(1, 1, 1);
        $centerSnapshot = $this->getRiddleSnapshotMock(2, 2, 2);
        $rightSnapshot = $this->getRiddleSnapshotMock(3, 3, 3);
        $puzzleSnapshot = new PuzzleSnapshot($topSnapshot, $middleSnapshot, $bottomSnapshot, $leftSnapshot, $centerSnapshot, $rightSnapshot);
        $this->assertTrue($validator->validate($puzzleSnapshot));
    }

    /**
     * @param int $alteredRowIndex
     * @param int $alteredColumnIndex
     * @dataProvider providesValidateReturnsFalseIfCellDoesNotMatchValueInDifferentDirection
     * @return void
     */
    public function testValidateReturnsFalseIfCellDoesNotMatchValueInDifferentDirection(int $alteredRowIndex, int $alteredColumnIndex): void
    {
        $validator = new CellValuesMatchAcrossRiddleSnapshotsValidator();

        $cells = [];
        for ($rowIndex = 1; $rowIndex <= 3; $rowIndex++) {
            for ($columnIndex = 1; $columnIndex <= 3; $columnIndex++) {
                $cells[$rowIndex][$columnIndex]['h'] = 1;
                $cells[$rowIndex][$columnIndex]['v'] = 1;
            }
        }
        $cells[$alteredRowIndex][$alteredColumnIndex]['h'] = 2;
        $cells[$alteredRowIndex][$alteredColumnIndex]['v'] = 3;

        $topSnapshot = $this->getRiddleSnapshotMock($cells[1][1]['h'], $cells[1][2]['h'], $cells[1][3]['h']);
        $middleSnapshot = $this->getRiddleSnapshotMock($cells[2][1]['h'], $cells[2][2]['h'], $cells[2][3]['h']);
        $bottomSnapshot = $this->getRiddleSnapshotMock($cells[3][1]['h'], $cells[3][2]['h'], $cells[3][3]['h']);
        $leftSnapshot = $this->getRiddleSnapshotMock($cells[1][1]['v'], $cells[2][1]['v'], $cells[3][1]['v']);
        $centerSnapshot = $this->getRiddleSnapshotMock($cells[1][2]['v'], $cells[2][2]['v'], $cells[3][2]['v']);
        $rightSnapshot = $this->getRiddleSnapshotMock($cells[1][3]['v'], $cells[2][3]['v'], $cells[3][3]['v']);

        $puzzleSnapshot = new PuzzleSnapshot($topSnapshot, $middleSnapshot, $bottomSnapshot, $leftSnapshot, $centerSnapshot, $rightSnapshot);

        $this->assertFalse($validator->validate($puzzleSnapshot));
    }

    /**
     * @param int $operand1
     * @param int $operand2
     * @param int $operand3
     * @return RiddleSnapshot|MockObject
     */
    public function getRiddleSnapshotMock(int $operand1, int $operand2, int $operand3): RiddleSnapshot|MockObject
    {
        $topSnapshot = $this->createMock(RiddleSnapshot::class);
        $topSnapshot->method('getOperand1')->willReturn($operand1);
        $topSnapshot->method('getOperand2')->willReturn($operand2);
        $topSnapshot->method('getOperand3')->willReturn($operand3);
        return $topSnapshot;
    }

    public function providesValidateReturnsFalseIfCellDoesNotMatchValueInDifferentDirection(): array
    {
        return [
            'cells-1-1-differ' => [1, 1],
            'cells-2-1-differ' => [2, 1],
            'cells-3-1-differ' => [3, 1],
            'cells-1-2-differ' => [1, 2],
            'cells-2-2-differ' => [2, 2],
            'cells-3-2-differ' => [3, 2],
            'cells-1-3-differ' => [1, 3],
            'cells-2-3-differ' => [2, 3],
            'cells-3-3-differ' => [3, 3],
        ];
    }
}
