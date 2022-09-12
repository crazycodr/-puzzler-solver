<?php

namespace App\CrossSums;

class PuzzleSnapshot
{

    /**
     * @return RiddleSnapshot
     */
    public function getTopSnapshot(): RiddleSnapshot
    {
        return $this->topSnapshot;
    }

    /**
     * @return RiddleSnapshot
     */
    public function getMiddleSnapshot(): RiddleSnapshot
    {
        return $this->middleSnapshot;
    }

    /**
     * @return RiddleSnapshot
     */
    public function getBottomSnapshot(): RiddleSnapshot
    {
        return $this->bottomSnapshot;
    }

    /**
     * @return RiddleSnapshot
     */
    public function getLeftSnapshot(): RiddleSnapshot
    {
        return $this->leftSnapshot;
    }

    /**
     * @return RiddleSnapshot
     */
    public function getCenterSnapshot(): RiddleSnapshot
    {
        return $this->centerSnapshot;
    }

    /**
     * @return RiddleSnapshot
     */
    public function getRightSnapshot(): RiddleSnapshot
    {
        return $this->rightSnapshot;
    }

    private RiddleSnapshot $topSnapshot;
    private RiddleSnapshot $middleSnapshot;
    private RiddleSnapshot $bottomSnapshot;
    private RiddleSnapshot $leftSnapshot;
    private RiddleSnapshot $centerSnapshot;
    private RiddleSnapshot $rightSnapshot;

    public function __construct(
        RiddleSnapshot $topSnapshot,
        RiddleSnapshot $middleSnapshot,
        RiddleSnapshot $bottomSnapshot,
        RiddleSnapshot $leftSnapshot,
        RiddleSnapshot $centerSnapshot,
        RiddleSnapshot $rightSnapshot
    )
    {
        $this->topSnapshot = $topSnapshot;
        $this->middleSnapshot = $middleSnapshot;
        $this->bottomSnapshot = $bottomSnapshot;
        $this->leftSnapshot = $leftSnapshot;
        $this->centerSnapshot = $centerSnapshot;
        $this->rightSnapshot = $rightSnapshot;
    }
}
