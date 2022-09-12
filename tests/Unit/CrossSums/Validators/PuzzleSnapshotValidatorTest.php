<?php

namespace Tests\Unit\CrossSums\Validators;

use App\CrossSums\PuzzleSnapshot;
use App\CrossSums\Validators\CellValuesMatchAcrossRiddleSnapshotsValidator;
use App\CrossSums\Validators\PuzzleSnapshotHasValidRiddleSnapshotsValidator;
use App\CrossSums\Validators\PuzzleSnapshotValidator;
use App\CrossSums\Validators\UniqueValuesAcrossPuzzleSnapshotValidator;
use PHPUnit\Framework\TestCase;

class PuzzleSnapshotValidatorTest extends TestCase
{
    /**
     * @dataProvider providesPuzzleSnapshotUsesThe3DependenciesAndMergesThem
     * @param bool $return1
     * @param bool $return2
     * @param bool $return3
     * @param bool $expected
     * @return void
     */
    public function testPuzzleSnapshotUsesThe3DependenciesAndMergesThem(bool $return1, bool $return2, bool $return3, bool $expected): void
    {
        $cellValuesMatchAcrossRiddleSnapshotsValidator = $this->createMock(CellValuesMatchAcrossRiddleSnapshotsValidator::class);
        $uniqueValuesAcrossPuzzleSnapshotValidator = $this->createMock(UniqueValuesAcrossPuzzleSnapshotValidator::class);
        $puzzleSnapshotHasValidRiddleSnapshotsValidator = $this->createMock(PuzzleSnapshotHasValidRiddleSnapshotsValidator::class);
        $validator = new PuzzleSnapshotValidator(
            $cellValuesMatchAcrossRiddleSnapshotsValidator,
            $uniqueValuesAcrossPuzzleSnapshotValidator,
            $puzzleSnapshotHasValidRiddleSnapshotsValidator
        );
        $puzzleSnapshot = $this->createMock(PuzzleSnapshot::class);
        $cellValuesMatchAcrossRiddleSnapshotsValidator->method('validate')->with($puzzleSnapshot)->willReturn($return1);
        $uniqueValuesAcrossPuzzleSnapshotValidator->method('validate')->with($puzzleSnapshot)->willReturn($return2);
        $puzzleSnapshotHasValidRiddleSnapshotsValidator->method('validate')->with($puzzleSnapshot)->willReturn($return3);
        $this->assertEquals($expected, $validator->areAllResultsExpected($puzzleSnapshot));
    }

    public function providesPuzzleSnapshotUsesThe3DependenciesAndMergesThem(): array
    {
        return [
            [true, true, true, true],
            [true, false, true, false],
            [true, true, false, false],
            [false, false, true, false],
            [false, true, false, false],
            [true, false, false, false],
            [false, false, false, false],
        ];
    }
}
