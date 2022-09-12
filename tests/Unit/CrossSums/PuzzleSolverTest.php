<?php

namespace Tests\Unit\CrossSums;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Puzzle;
use App\CrossSums\PuzzleSolver;
use App\CrossSums\Riddle;
use App\CrossSums\Validators\CellValuesMatchAcrossRiddleSnapshotsValidator;
use App\CrossSums\Validators\CompareRiddleCellsValidator;
use App\CrossSums\Validators\InvalidCellIndexException;
use App\CrossSums\Validators\PuzzleSnapshotHasValidRiddleSnapshotsValidator;
use App\CrossSums\Validators\PuzzleSnapshotValidator;
use App\CrossSums\Validators\UniqueValuesAcrossPuzzleSnapshotValidator;
use PHPUnit\Framework\TestCase;

class PuzzleSolverTest extends TestCase
{
    const ONE_MEGABYTE = 1 * 1024 * 1024;

    /**
     * @throws InvalidOperatorException
     */
    public function testPuzzlePersistsThePassedInPuzzle(): void
    {
        $riddle1 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle2 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle3 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle4 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle5 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle6 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $puzzle = new Puzzle($riddle1, $riddle2, $riddle3, $riddle4, $riddle5, $riddle6);
        $puzzleSnapshotValidator = new PuzzleSnapshotValidator(
            new CellValuesMatchAcrossRiddleSnapshotsValidator(),
            new UniqueValuesAcrossPuzzleSnapshotValidator(),
            new PuzzleSnapshotHasValidRiddleSnapshotsValidator()
        );
        $cellValidator = new CompareRiddleCellsValidator();
        $puzzleSolver = new PuzzleSolver($puzzle, $puzzleSnapshotValidator, $cellValidator);
        $this->assertSame($puzzle, $puzzleSolver->getPuzzle());
    }

    /**
     * @throws InvalidOperatorException|InvalidCellIndexException
     */
    public function testGetAllSolutionsReturnExpectedSolutions(): void
    {
        $riddle1 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 15);
        $riddle2 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 17);
        $riddle3 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 12);
        $riddle4 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 22);
        $riddle5 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 84);
        $riddle6 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 32);
        $puzzle = new Puzzle($riddle1, $riddle2, $riddle3, $riddle4, $riddle5, $riddle6);
        $puzzleSnapshotValidator = new PuzzleSnapshotValidator(
            new CellValuesMatchAcrossRiddleSnapshotsValidator(),
            new UniqueValuesAcrossPuzzleSnapshotValidator(),
            new PuzzleSnapshotHasValidRiddleSnapshotsValidator()
        );
        $cellValidator = new CompareRiddleCellsValidator();
        $puzzleSolver = new PuzzleSolver($puzzle, $puzzleSnapshotValidator, $cellValidator);
        $beforeMem = memory_get_peak_usage();
        $solutions = $puzzleSolver->getValidSolutions();
        $this->assertEquals(3, $solutions[0]->getTopSnapshot()->getOperand1());
        $this->assertEquals(5, $solutions[0]->getTopSnapshot()->getOperand2());
        $this->assertEquals(7, $solutions[0]->getTopSnapshot()->getOperand3());
        $this->assertEquals(8, $solutions[0]->getMiddleSnapshot()->getOperand1());
        $this->assertEquals(9, $solutions[0]->getMiddleSnapshot()->getOperand2());
        $this->assertEquals(1, $solutions[0]->getMiddleSnapshot()->getOperand3());
        $this->assertEquals(2, $solutions[0]->getBottomSnapshot()->getOperand1());
        $this->assertEquals(6, $solutions[0]->getBottomSnapshot()->getOperand2());
        $this->assertEquals(4, $solutions[0]->getBottomSnapshot()->getOperand3());
        $this->assertEquals(3, $solutions[0]->getLeftSnapshot()->getOperand1());
        $this->assertEquals(8, $solutions[0]->getLeftSnapshot()->getOperand2());
        $this->assertEquals(2, $solutions[0]->getLeftSnapshot()->getOperand3());
        $this->assertEquals(5, $solutions[0]->getCenterSnapshot()->getOperand1());
        $this->assertEquals(9, $solutions[0]->getCenterSnapshot()->getOperand2());
        $this->assertEquals(6, $solutions[0]->getCenterSnapshot()->getOperand3());
        $this->assertEquals(7, $solutions[0]->getRightSnapshot()->getOperand1());
        $this->assertEquals(1, $solutions[0]->getRightSnapshot()->getOperand2());
        $this->assertEquals(4, $solutions[0]->getRightSnapshot()->getOperand3());
        $afterMem = memory_get_peak_usage();
        echo $afterMem - $beforeMem;
    }

    /**
     * @throws InvalidOperatorException|InvalidCellIndexException
     */
    public function testGetAllSolutionsIsTimeEfficient(): void
    {
        $start = microtime(true);
        $riddle1 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 15);
        $riddle2 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 17);
        $riddle3 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 12);
        $riddle4 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 22);
        $riddle5 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 84);
        $riddle6 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 32);
        $puzzle = new Puzzle($riddle1, $riddle2, $riddle3, $riddle4, $riddle5, $riddle6);
        $puzzleSnapshotValidator = new PuzzleSnapshotValidator(
            new CellValuesMatchAcrossRiddleSnapshotsValidator(),
            new UniqueValuesAcrossPuzzleSnapshotValidator(),
            new PuzzleSnapshotHasValidRiddleSnapshotsValidator()
        );
        $cellValidator = new CompareRiddleCellsValidator();
        $puzzleSolver = new PuzzleSolver($puzzle, $puzzleSnapshotValidator, $cellValidator);
        $puzzleSolver->getValidSolutions();
        $end = microtime(true);
        $this->assertLessThan(0.5, $start - $end);
    }

    /**
     * @throws InvalidOperatorException|InvalidCellIndexException
     */
    public function testGetAllSolutionsIsMemoryEfficient(): void
    {
        $start = memory_get_peak_usage(true);
        $riddle1 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 15);
        $riddle2 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 17);
        $riddle3 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 12);
        $riddle4 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 22);
        $riddle5 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 84);
        $riddle6 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 32);
        $puzzle = new Puzzle($riddle1, $riddle2, $riddle3, $riddle4, $riddle5, $riddle6);
        $puzzleSnapshotValidator = new PuzzleSnapshotValidator(
            new CellValuesMatchAcrossRiddleSnapshotsValidator(),
            new UniqueValuesAcrossPuzzleSnapshotValidator(),
            new PuzzleSnapshotHasValidRiddleSnapshotsValidator()
        );
        $cellValidator = new CompareRiddleCellsValidator();
        $puzzleSolver = new PuzzleSolver($puzzle, $puzzleSnapshotValidator, $cellValidator);
        $puzzleSolver->getValidSolutions();
        $end = memory_get_peak_usage(true);
        $this->assertLessThan(self::ONE_MEGABYTE, $start - $end);
    }
}
