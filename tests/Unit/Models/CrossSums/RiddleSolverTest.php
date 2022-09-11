<?php

namespace Tests\Unit\Models\CrossSums;

use App\Models\CrossSums\Riddle;
use App\Models\CrossSums\RiddleSnapshot;
use App\Models\CrossSums\RiddleSolver;
use App\Models\CrossSums\InvalidOperatorException;
use PHPUnit\Framework\TestCase;

class RiddleSolverTest extends TestCase
{

    /**
     * @throws InvalidOperatorException
     */
    public function testGetAllSolutionsReturnAllPermutationsOf3Numbers()
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $expected = [
            new RiddleSnapshot(1, 2, 3, $riddle),
            new RiddleSnapshot(1, 3, 2, $riddle),
            new RiddleSnapshot(2, 1, 3, $riddle),
            new RiddleSnapshot(2, 3, 1, $riddle),
            new RiddleSnapshot(3, 1, 2, $riddle),
            new RiddleSnapshot(3, 2, 1, $riddle),
        ];
        $solver = new RiddleSolver($riddle);
        $attempts = $solver->getAllSolutions([1, 2, 3]);
        $this->assertEquals($expected, $attempts);
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testGetValidSolutionsReturnOnlyExpectedSolutions()
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 9);
        $expected = [
            new RiddleSnapshot(1, 2, 3, $riddle),
            new RiddleSnapshot(2, 1, 3, $riddle),
        ];
        $solver = new RiddleSolver($riddle);
        $attempts = $solver->getValidSolutions([1, 2, 3]);
        $this->assertEquals($expected, array_values($attempts));
    }

    /**
     * @throws InvalidOperatorException
     */
    public function testRiddleIsProperlyPersisted()
    {
        $riddle = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_MUL, 9);
        $solver = new RiddleSolver($riddle);
        $this->assertSame($riddle, $solver->getRiddle());
    }
}
