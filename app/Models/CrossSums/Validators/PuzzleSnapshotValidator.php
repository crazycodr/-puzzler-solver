<?php

namespace App\Models\CrossSums\Validators;

use App\Models\CrossSums\PuzzleSnapshot;

class PuzzleSnapshotValidator
{

    private CellValuesMatchAcrossRiddleSnapshotsValidator $cellValuesMatchAcrossRiddleSnapshotsValidator;
    private UniqueValuesAcrossPuzzleSnapshotValidator $uniqueValuesAcrossPuzzleSnapshotValidator;
    private PuzzleSnapshotHasValidRiddleSnapshotsValidator $puzzleSnapshotHasValidRiddleSnapshotsValidator;

    public function __construct(
        CellValuesMatchAcrossRiddleSnapshotsValidator  $cellValuesMatchAcrossRiddleSnapshotsValidator,
        UniqueValuesAcrossPuzzleSnapshotValidator      $uniqueValuesAcrossPuzzleSnapshotValidator,
        PuzzleSnapshotHasValidRiddleSnapshotsValidator $puzzleSnapshotHasValidRiddleSnapshotsValidator
    )
    {
        $this->cellValuesMatchAcrossRiddleSnapshotsValidator = $cellValuesMatchAcrossRiddleSnapshotsValidator;
        $this->uniqueValuesAcrossPuzzleSnapshotValidator = $uniqueValuesAcrossPuzzleSnapshotValidator;
        $this->puzzleSnapshotHasValidRiddleSnapshotsValidator = $puzzleSnapshotHasValidRiddleSnapshotsValidator;
    }

    public function areAllResultsExpected(PuzzleSnapshot $puzzleSnapshot): bool
    {
        return $this->cellValuesMatchAcrossRiddleSnapshotsValidator->validate($puzzleSnapshot)
            && $this->uniqueValuesAcrossPuzzleSnapshotValidator->validate($puzzleSnapshot)
            && $this->puzzleSnapshotHasValidRiddleSnapshotsValidator->validate($puzzleSnapshot);
    }
}
