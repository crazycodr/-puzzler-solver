<?php

namespace App\CrossSums\Validators;

use App\CrossSums\PuzzleSnapshot;

class PuzzleSnapshotHasValidRiddleSnapshotsValidator
{

    public function validate(PuzzleSnapshot $puzzleSnapshot): bool
    {
        return $puzzleSnapshot->getTopSnapshot()->isResultExpected()
            && $puzzleSnapshot->getMiddleSnapshot()->isResultExpected()
            && $puzzleSnapshot->getBottomSnapshot()->isResultExpected()
            && $puzzleSnapshot->getLeftSnapshot()->isResultExpected()
            && $puzzleSnapshot->getCenterSnapshot()->isResultExpected()
            && $puzzleSnapshot->getRightSnapshot()->isResultExpected();
    }
}
