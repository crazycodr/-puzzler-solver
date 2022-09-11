<?php

namespace App\Models\CrossSums\Validators;

use App\Models\CrossSums\PuzzleSnapshot;

class UniqueValuesAcrossPuzzleSnapshotValidator
{

    public function validate(PuzzleSnapshot $puzzleSnapshot): bool
    {
        return $this->validateHorizontal($puzzleSnapshot)
            && $this->validateVertical($puzzleSnapshot);
    }

    private function validateHorizontal(PuzzleSnapshot $puzzleSnapshot): bool
    {
        $values = [];
        $values[] = $puzzleSnapshot->getTopSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getTopSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getTopSnapshot()->getOperand3();
        $values[] = $puzzleSnapshot->getMiddleSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getMiddleSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getMiddleSnapshot()->getOperand3();
        $values[] = $puzzleSnapshot->getBottomSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getBottomSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getBottomSnapshot()->getOperand3();
        return count(array_unique($values)) === count($values);
    }

    private function validateVertical(PuzzleSnapshot $puzzleSnapshot): bool
    {
        $values = [];
        $values[] = $puzzleSnapshot->getLeftSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getLeftSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getLeftSnapshot()->getOperand3();
        $values[] = $puzzleSnapshot->getCenterSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getCenterSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getCenterSnapshot()->getOperand3();
        $values[] = $puzzleSnapshot->getRightSnapshot()->getOperand1();
        $values[] = $puzzleSnapshot->getRightSnapshot()->getOperand2();
        $values[] = $puzzleSnapshot->getRightSnapshot()->getOperand3();
        return count(array_unique($values)) === count($values);
    }
}
