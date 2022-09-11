<?php

namespace Tests\Unit\Models\CrossSums;

use App\Models\CrossSums\InvalidOperatorException;
use App\Models\CrossSums\Puzzle;
use App\Models\CrossSums\Riddle;
use PHPUnit\Framework\TestCase;

class PuzzleTest extends TestCase
{

    /**
     * @throws InvalidOperatorException
     */
    public function testPuzzlePersistsThePassedInRiddles(): void
    {
        $riddle1 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle2 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle3 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle4 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle5 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $riddle6 = new Riddle(Riddle::OPERATOR_ADD, Riddle::OPERATOR_ADD, 0);
        $puzzle = new Puzzle($riddle1, $riddle2, $riddle3, $riddle4, $riddle5, $riddle6);
        $this->assertSame($riddle1, $puzzle->getTopRiddle());
        $this->assertSame($riddle2, $puzzle->getMiddleRiddle());
        $this->assertSame($riddle3, $puzzle->getBottomRiddle());
        $this->assertSame($riddle4, $puzzle->getLeftRiddle());
        $this->assertSame($riddle5, $puzzle->getCenterRiddle());
        $this->assertSame($riddle6, $puzzle->getRightRiddle());
    }
}
