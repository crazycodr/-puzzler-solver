<?php

namespace App\CrossSums;

class RiddleSolver
{

    /**
     * @var Riddle
     */
    private $riddle;

    public function __construct(Riddle $riddle)
    {
        $this->riddle = $riddle;
    }

    /**
     * @return Riddle
     */
    public function getRiddle(): Riddle
    {
        return $this->riddle;
    }

    /**
     * @return RiddleSnapshot[]
     */
    public function getAllSolutions(array $availableNumbers): array
    {
        $attempts = [];
        $firstPassNumbers = $availableNumbers;
        foreach ($firstPassNumbers as $firstPassNumber) {
            $secondPassNumbers = array_filter($firstPassNumbers, function (int $number) use ($firstPassNumber) {
                return $number !== $firstPassNumber;
            });
            foreach ($secondPassNumbers as $secondPassNumber) {
                $thirdPassNumbers = array_filter($secondPassNumbers, function (int $number) use ($secondPassNumber) {
                    return $number !== $secondPassNumber;
                });
                foreach ($thirdPassNumbers as $thirdPassNumber) {
                    $attempts[] = new RiddleSnapshot($firstPassNumber, $secondPassNumber, $thirdPassNumber, $this->getRiddle());
                }
            }
        }
        return $attempts;
    }

    /**
     * @return RiddleSnapshot[]
     */
    public function getValidSolutions(array $availableNumbers): array
    {
        return array_filter($this->getAllSolutions($availableNumbers), function (RiddleSnapshot $snapshot) {
            return $snapshot->isResultExpected();
        });
    }

}
