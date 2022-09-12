<?php

namespace App\Futoshikis\Models;

class Cell
{

    private bool $isEmpty = true;
    private array $marks = [];
    private int $value = 0;

    public function isEmpty(): bool
    {
        return $this->isEmpty;
    }

    public function isFilled(): bool
    {
        return $this->isEmpty === false;
    }

    public function eraseValue(): void
    {
        $this->isEmpty = true;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
        $this->isEmpty = false;
        $this->marks = [$value];
    }

    public function getMarks(): array
    {
        return $this->marks;
    }

    public function setMarks(array $marks): void
    {
        $this->marks = array_values($marks);
    }

    public function isSolved(): bool
    {
        return $this->isFilled();
    }

}
