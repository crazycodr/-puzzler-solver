<?php

namespace App\Models\CrossSums\Validators;

use App\Models\CrossSums\PuzzleSnapshot;

class CellValuesMatchAcrossRiddleSnapshotsValidator
{

    public function validate(PuzzleSnapshot $puzzleSnapshot): bool
    {
        if ($puzzleSnapshot->getTopSnapshot()->getOperand1() !== $puzzleSnapshot->getLeftSnapshot()->getOperand1()) {
            return false;
        }
        if ($puzzleSnapshot->getTopSnapshot()->getOperand2() !== $puzzleSnapshot->getCenterSnapshot()->getOperand1()) {
            return false;
        }
        if ($puzzleSnapshot->getTopSnapshot()->getOperand3() !== $puzzleSnapshot->getRightSnapshot()->getOperand1()) {
            return false;
        }
        if ($puzzleSnapshot->getMiddleSnapshot()->getOperand1() !== $puzzleSnapshot->getLeftSnapshot()->getOperand2()) {
            return false;
        }
        if ($puzzleSnapshot->getMiddleSnapshot()->getOperand2() !== $puzzleSnapshot->getCenterSnapshot()->getOperand2()) {
            return false;
        }
        if ($puzzleSnapshot->getMiddleSnapshot()->getOperand3() !== $puzzleSnapshot->getRightSnapshot()->getOperand2()) {
            return false;
        }
        if ($puzzleSnapshot->getBottomSnapshot()->getOperand1() !== $puzzleSnapshot->getLeftSnapshot()->getOperand3()) {
            return false;
        }
        if ($puzzleSnapshot->getBottomSnapshot()->getOperand2() !== $puzzleSnapshot->getCenterSnapshot()->getOperand3()) {
            return false;
        }
        if ($puzzleSnapshot->getBottomSnapshot()->getOperand3() !== $puzzleSnapshot->getRightSnapshot()->getOperand3()) {
            return false;
        }
        return true;
    }
}
