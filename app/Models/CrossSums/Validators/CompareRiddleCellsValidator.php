<?php

namespace App\Models\CrossSums\Validators;

use App\Models\CrossSums\RiddleSnapshot;

class CompareRiddleCellsValidator
{

    /**
     * @throws InvalidCellIndexException
     */
    public function validate(RiddleSnapshot $horizontalRiddle, RiddleSnapshot $verticalRiddle, int $horizontalCellIndex, int $verticalCellIndex): bool
    {
        $horizontalValue = match ($horizontalCellIndex) {
            0 => $horizontalRiddle->getOperand1(),
            1 => $horizontalRiddle->getOperand2(),
            2 => $horizontalRiddle->getOperand3(),
            default => throw new InvalidCellIndexException('horizontal', $horizontalCellIndex),
        };
        $verticalValue = match ($verticalCellIndex) {
            0 => $verticalRiddle->getOperand1(),
            1 => $verticalRiddle->getOperand2(),
            2 => $verticalRiddle->getOperand3(),
            default => throw new InvalidCellIndexException('horizontal', $horizontalCellIndex),
        };
        return $horizontalValue === $verticalValue;
    }
}
