<?php

namespace App\Console\Commands;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Puzzle;
use App\CrossSums\PuzzleSolver;
use App\CrossSums\Riddle;
use App\CrossSums\RiddleSnapshot;
use App\CrossSums\Validators\CellValuesMatchAcrossRiddleSnapshotsValidator;
use App\CrossSums\Validators\CompareRiddleCellsValidator;
use App\CrossSums\Validators\InvalidCellIndexException;
use App\CrossSums\Validators\PuzzleSnapshotHasValidRiddleSnapshotsValidator;
use App\CrossSums\Validators\PuzzleSnapshotValidator;
use App\CrossSums\Validators\UniqueValuesAcrossPuzzleSnapshotValidator;
use Illuminate\Console\Command;

class CrossSumsSolvePuzzleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cross-sums:solve:puzzle {top-riddle} {middle-riddle} {bottom-riddle} {left-riddle} {center-riddle} {right-riddle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solves a full puzzle with the 6 possible riddles by printing all possible solutions to each riddle in a CrossSums puzzle, pass in multiple valid equations with operators separated by spaces such as "+ + = 6". Use a double dash if equation starts with - or it expects a short flag specification that does not exist.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws InvalidCellIndexException
     */
    public function handle(): int
    {
        try {
            $topRiddle = $this->processEquationToRiddle($this->argument('top-riddle'));
            $middleRiddle = $this->processEquationToRiddle($this->argument('middle-riddle'));
            $bottomRiddle = $this->processEquationToRiddle($this->argument('bottom-riddle'));
            $leftRiddle = $this->processEquationToRiddle($this->argument('left-riddle'));
            $centerRiddle = $this->processEquationToRiddle($this->argument('center-riddle'));
            $rightRiddle = $this->processEquationToRiddle($this->argument('right-riddle'));
        } catch (InvalidOperatorException $e) {
            $this->error('Invalid argument for one of the operators, only "+, -, *, /" are authorized');
            return -1;
        }

        $puzzle = new Puzzle($topRiddle, $middleRiddle, $bottomRiddle, $leftRiddle, $centerRiddle, $rightRiddle);
        $puzzleSolver = new PuzzleSolver($puzzle, new PuzzleSnapshotValidator(
            new CellValuesMatchAcrossRiddleSnapshotsValidator(),
            new UniqueValuesAcrossPuzzleSnapshotValidator(),
            new PuzzleSnapshotHasValidRiddleSnapshotsValidator()
        ), new CompareRiddleCellsValidator());
        foreach ($puzzleSolver->getValidSolutions() as $solution)
        {
            $this->info('');
            $this->info($this->getHorizontalSnapshotSolutionString($solution->getTopSnapshot()));
            $this->info($this->getVerticalSnapshotsSolutionString(
                $solution->getLeftSnapshot()->getRiddle()->getOperator1(),
                $solution->getCenterSnapshot()->getRiddle()->getOperator1(),
                $solution->getRightSnapshot()->getRiddle()->getOperator1()
            ));
            $this->info($this->getHorizontalSnapshotSolutionString($solution->getMiddleSnapshot()));
            $this->info($this->getVerticalSnapshotsSolutionString(
                $solution->getLeftSnapshot()->getRiddle()->getOperator2(),
                $solution->getCenterSnapshot()->getRiddle()->getOperator2(),
                $solution->getRightSnapshot()->getRiddle()->getOperator2()
            ));
            $this->info($this->getHorizontalSnapshotSolutionString($solution->getBottomSnapshot()));
            $this->info('=   =   =');
            $this->info($this->getVerticalSnapshotsSolutionString(
                $solution->getLeftSnapshot()->getRiddle()->getExpectedResult(),
                $solution->getCenterSnapshot()->getRiddle()->getExpectedResult(),
                $solution->getRightSnapshot()->getRiddle()->getExpectedResult()
            ));
        }

        return 0;
    }

    /**
     * @throws InvalidOperatorException
     */
    private function processEquationToRiddle(string $equation): Riddle
    {
        list($operator1, $operator2, $uselessEqualSign, $expectedResult) = explode(' ', $equation);
        unset($uselessEqualSign);
        return new Riddle($operator1, $operator2, $expectedResult);
    }

    /**
     * @param RiddleSnapshot $riddleSnapshot
     * @return string
     */
    public function getHorizontalSnapshotSolutionString(RiddleSnapshot $riddleSnapshot): string
    {
        return sprintf('%d %s %d %s %d = %d',
            $riddleSnapshot->getOperand1(),
            $riddleSnapshot->getRiddle()->getOperator1(),
            $riddleSnapshot->getOperand2(),
            $riddleSnapshot->getRiddle()->getOperator2(),
            $riddleSnapshot->getOperand3(),
            $riddleSnapshot->getRiddle()->getExpectedResult(),
        );
    }

    private function getVerticalSnapshotsSolutionString(string $operator1, string $operator2, string $operator3): string
    {
        return sprintf('%s   %s   %s',
            $operator1,
            $operator2,
            $operator3,
        );
    }
}
