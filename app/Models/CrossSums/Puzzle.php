<?php

namespace App\Models\CrossSums;

class Puzzle {

    /**
     * @var Riddle
     */
    private Riddle $topHorizontalRiddle;

    /**
     * @var Riddle
     */
    private Riddle $middleHorizontalRiddle;

    /**
     * @var Riddle
     */
    private Riddle $bottomHorizontalRiddle;

    /**
     * @var Riddle
     */
    private Riddle $leftVerticalRiddle;

    /**
     * @var Riddle
     */
    private Riddle $centerVerticalRiddle;

    /**
     * @var Riddle
     */
    private Riddle $rightVerticalRiddle;

    public function __construct(
        Riddle $topHorizontalRiddle,
        Riddle $middleHorizontalRiddle,
        Riddle $bottomHorizontalRiddle,
        Riddle $leftVerticalRiddle,
        Riddle $centerVerticalRiddle,
        Riddle $rightVerticalRiddle
    ) {

        $this->topHorizontalRiddle = $topHorizontalRiddle;
        $this->middleHorizontalRiddle = $middleHorizontalRiddle;
        $this->bottomHorizontalRiddle = $bottomHorizontalRiddle;
        $this->leftVerticalRiddle = $leftVerticalRiddle;
        $this->centerVerticalRiddle = $centerVerticalRiddle;
        $this->rightVerticalRiddle = $rightVerticalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getTopRiddle(): Riddle
    {
        return $this->topHorizontalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getMiddleRiddle(): Riddle
    {
        return $this->middleHorizontalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getBottomRiddle(): Riddle
    {
        return $this->bottomHorizontalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getLeftRiddle(): Riddle
    {
        return $this->leftVerticalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getCenterRiddle(): Riddle
    {
        return $this->centerVerticalRiddle;
    }

    /**
     * @return Riddle
     */
    public function getRightRiddle(): Riddle
    {
        return $this->rightVerticalRiddle;
    }

}
