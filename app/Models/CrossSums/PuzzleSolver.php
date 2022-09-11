<?php

namespace App\Models\CrossSums;

use App\Models\CrossSums\Validators\CompareRiddleCellsValidator;
use App\Models\CrossSums\Validators\PuzzleSnapshotValidator;

class PuzzleSolver
{

    private Puzzle $puzzle;
    private PuzzleSnapshotValidator $snapshotValidator;
    private CompareRiddleCellsValidator $cellsValidator;

    public function __construct(Puzzle $puzzle, PuzzleSnapshotValidator $snapshotValidator, CompareRiddleCellsValidator $cellsValidator)
    {
        $this->puzzle = $puzzle;
        $this->snapshotValidator = $snapshotValidator;
        $this->cellsValidator = $cellsValidator;
    }

    /**
     * @return Puzzle
     */
    public function getPuzzle(): Puzzle
    {
        return $this->puzzle;
    }

    /**
     * @return PuzzleSnapshot[]
     * @throws Validators\InvalidCellIndexException
     */
    public function getValidSolutions(): array
    {
        $solutions = [];
        $topRiddleSolver = new RiddleSolver($this->getPuzzle()->getTopRiddle());
        $middleRiddleSolver = new RiddleSolver($this->getPuzzle()->getMiddleRiddle());
        $bottomRiddleSolver = new RiddleSolver($this->getPuzzle()->getBottomRiddle());
        $leftRiddleSolver = new RiddleSolver($this->getPuzzle()->getLeftRiddle());
        $centerRiddleSolver = new RiddleSolver($this->getPuzzle()->getCenterRiddle());
        $rightRiddleSolver = new RiddleSolver($this->getPuzzle()->getRightRiddle());
        $availableNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $topRiddleSolutions = $topRiddleSolver->getValidSolutions($availableNumbers);
        $middleRiddleSolutions = $middleRiddleSolver->getValidSolutions($availableNumbers);
        $bottomRiddleSolutions = $bottomRiddleSolver->getValidSolutions($availableNumbers);
        $leftRiddleSolutions = $leftRiddleSolver->getValidSolutions($availableNumbers);
        $centerRiddleSolutions = $centerRiddleSolver->getValidSolutions($availableNumbers);
        $rightRiddleSolutions = $rightRiddleSolver->getValidSolutions($availableNumbers);
        foreach ($topRiddleSolutions as $topRiddleSolution) {
            foreach ($leftRiddleSolutions as $leftRiddleSolution) {
                if ($this->cellsValidator->validate($topRiddleSolution, $leftRiddleSolution, 0, 0) === false) {
                    continue;
                }
                foreach ($centerRiddleSolutions as $centerRiddleSolution) {
                    if ($this->cellsValidator->validate($topRiddleSolution, $centerRiddleSolution, 1, 0) === false) {
                        continue;
                    }
                    foreach ($rightRiddleSolutions as $rightRiddleSolution) {
                        if ($this->cellsValidator->validate($topRiddleSolution, $rightRiddleSolution, 2, 0) === false) {
                            continue;
                        }
                        foreach ($middleRiddleSolutions as $middleRiddleSolution) {
                            foreach ($bottomRiddleSolutions as $bottomRiddleSolution) {
                                $possibleSolution = new PuzzleSnapshot(
                                    $topRiddleSolution,
                                    $middleRiddleSolution,
                                    $bottomRiddleSolution,
                                    $leftRiddleSolution,
                                    $centerRiddleSolution,
                                    $rightRiddleSolution
                                );
                                if ($this->snapshotValidator->areAllResultsExpected($possibleSolution)) {
                                    $solutions[] = $possibleSolution;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $solutions;
    }

}
