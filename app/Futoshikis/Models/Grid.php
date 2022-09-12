<?php

namespace App\Futoshikis\Models;

class Grid
{
    public readonly int $size;
    private array $rules;
    private array $cells = [];

    public function __construct(int $size)
    {
        $this->size = $size;
        $initialMarks = range(1, $size);
        for ($row = 0; $row < $size; $row++) {
            for ($col = 0; $col < $size; $col++) {
                $this->cells[$row][$col] = new Cell();
                $this->cells[$row][$col]->setMarks($initialMarks);
            }
        }
    }

    public function addRule(Rule $rule): Grid
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    public function getCell(GridPosition $position): Cell
    {
        return $this->cells[$position->row][$position->col];
    }

    public function isSolved(): bool
    {
        for ($row=0; $row<$this->size; $row++){
            for ($col=0; $col<$this->size; $col++){
                $cellPosition = new GridPosition($row, $col);
                $cell = $this->getCell($cellPosition);
                if ($cell->isSolved() === false){
                    return false;
                }
            }
        }
        return true;
    }
}
