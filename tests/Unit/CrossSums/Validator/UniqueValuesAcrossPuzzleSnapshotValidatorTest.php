<?php

namespace Tests\Unit\CrossSums\Validator;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\PuzzleSnapshot;
use App\CrossSums\Riddle;
use App\CrossSums\RiddleSnapshot;
use App\CrossSums\Validators\UniqueValuesAcrossPuzzleSnapshotValidator;
use Tests\TestCase;

class UniqueValuesAcrossPuzzleSnapshotValidatorTest extends TestCase
{
    /**
     * @throws InvalidOperatorException
     */
    public function testValidateWithUniqueValuesReturnTrue(): void
    {
        $stubRiddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $uniqueHorizontalValues123Snapshot = new RiddleSnapshot(1,2,3, $stubRiddle);
        $uniqueHorizontalValues456Snapshot = new RiddleSnapshot(4,5,6, $stubRiddle);
        $uniqueHorizontalValues789Snapshot = new RiddleSnapshot(7,8,9, $stubRiddle);
        $uniqueVerticalValues147Snapshot = new RiddleSnapshot(1,4,7, $stubRiddle);
        $uniqueVerticalValues258Snapshot = new RiddleSnapshot(2,5,8, $stubRiddle);
        $uniqueVerticalValues369Snapshot = new RiddleSnapshot(3,6,9, $stubRiddle);
        $puzzleSnapshot = new PuzzleSnapshot(
            $uniqueHorizontalValues123Snapshot,
            $uniqueHorizontalValues456Snapshot,
            $uniqueHorizontalValues789Snapshot,
            $uniqueVerticalValues147Snapshot,
            $uniqueVerticalValues258Snapshot,
            $uniqueVerticalValues369Snapshot
        );
        $validator = new UniqueValuesAcrossPuzzleSnapshotValidator();
        $this->assertTrue($validator->validate($puzzleSnapshot));
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testValidateWithNonUniqueValuesReturnFalse(): void
    {
        $stubRiddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $uniqueHorizontalValues123Snapshot = new RiddleSnapshot(1,2,3, $stubRiddle);
        $uniqueHorizontalValues456Snapshot = new RiddleSnapshot(2,5,6, $stubRiddle);
        $uniqueHorizontalValues789Snapshot = new RiddleSnapshot(7,8,9, $stubRiddle);
        $uniqueVerticalValues147Snapshot = new RiddleSnapshot(1,4,7, $stubRiddle);
        $uniqueVerticalValues258Snapshot = new RiddleSnapshot(2,5,8, $stubRiddle);
        $uniqueVerticalValues369Snapshot = new RiddleSnapshot(3,6,9, $stubRiddle);
        $puzzleSnapshot = new PuzzleSnapshot(
            $uniqueHorizontalValues123Snapshot,
            $uniqueHorizontalValues456Snapshot,
            $uniqueHorizontalValues789Snapshot,
            $uniqueVerticalValues147Snapshot,
            $uniqueVerticalValues258Snapshot,
            $uniqueVerticalValues369Snapshot
        );
        $validator = new UniqueValuesAcrossPuzzleSnapshotValidator();
        $this->assertFalse($validator->validate($puzzleSnapshot));
    }
}
