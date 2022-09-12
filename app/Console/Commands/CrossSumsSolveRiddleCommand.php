<?php

namespace App\Console\Commands;

use App\CrossSums\InvalidOperatorException;
use App\CrossSums\Riddle;
use App\CrossSums\RiddleSolver;
use Illuminate\Console\Command;

class CrossSumsSolveRiddleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cross-sums:solve:riddle {riddle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solves a single riddle by printing all possible solutions to it in a CrossSums puzzle, pass in a valid equation with operators separated by spaces such as "+ + = 6". Use a double dash if riddle starts with - or it expects a short flag specification that does not exist.';

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
     */
    public function handle()
    {
        $riddle = $this->argument('riddle');
        list($operator1, $operator2, $uselessEqualSign, $expectedResult) = explode(' ', $riddle);
        unset($uselessEqualSign);
        try {
            $riddle = new Riddle($operator1, $operator2, $expectedResult);
            $solver = new RiddleSolver($riddle);
            $solutions = $solver->getValidSolutions([1, 2, 3, 4, 5, 6, 7, 8, 9]);
            foreach ($solutions as $solution) {
                $solutionString = sprintf('%d %s %d %s %d = %d',
                    $solution->getOperand1(),
                    $solution->getRiddle()->getOperator1(),
                    $solution->getOperand2(),
                    $solution->getRiddle()->getOperator2(),
                    $solution->getOperand3(),
                    $solution->getRiddle()->getExpectedResult(),
                );
                $this->info($solutionString);
            }
        } catch (InvalidOperatorException $e) {
            $this->error('Invalid argument for one of the operators, only "+, -, *, /" are authorized');
            return -1;
        }
        return 0;
    }
}
