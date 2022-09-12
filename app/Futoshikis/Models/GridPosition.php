<?php

namespace App\Futoshikis\Models;

class GridPosition
{
    public readonly int $row;
    public readonly int $col;

    public function __construct(int $row, int $col)
    {
        $this->row = $row;
        $this->col = $col;
    }

    public function isEqualTo(GridPosition $comparedTo): bool
    {
        return $this->row === $comparedTo->row
            && $this->col === $comparedTo->col;
    }
}
