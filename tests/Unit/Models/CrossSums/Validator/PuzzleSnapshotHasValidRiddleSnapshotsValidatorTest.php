<?php

namespace Tests\Unit\Models\CrossSums\Validator;

use App\CrossSums\PuzzleSnapshot;
use App\CrossSums\RiddleSnapshot;
use App\CrossSums\Validators\PuzzleSnapshotHasValidRiddleSnapshotsValidator;
use PHPUnit\Framework\TestCase;

class PuzzleSnapshotHasValidRiddleSnapshotsValidatorTest extends TestCase
{
    public function testValidateWithOneInvalidRiddleSnapshotFailsToValidate(): void
    {
        $validRiddleSnapshot = $this->createMock(RiddleSnapshot::class);
        $validRiddleSnapshot->method('isResultExpected')->willReturn(true);
        $invalidRiddleSnapshot = $this->createMock(RiddleSnapshot::class);
        $invalidRiddleSnapshot->method('isResultExpected')->willReturn(false);
        $puzzleSnapshot = new PuzzleSnapshot($validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $invalidRiddleSnapshot);
        $validator = new PuzzleSnapshotHasValidRiddleSnapshotsValidator();
        $this->assertFalse($validator->validate($puzzleSnapshot));
    }

    public function testValidateWithAllValidRiddleSnapshotSucceedsToValidate(): void
    {
        $validRiddleSnapshot = $this->createMock(RiddleSnapshot::class);
        $validRiddleSnapshot->method('isResultExpected')->willReturn(true);
        $puzzleSnapshot = new PuzzleSnapshot($validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot, $validRiddleSnapshot);
        $validator = new PuzzleSnapshotHasValidRiddleSnapshotsValidator();
        $this->assertTrue($validator->validate($puzzleSnapshot));
    }
}
