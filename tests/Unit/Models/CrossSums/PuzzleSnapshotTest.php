<?php

namespace Tests\Unit\Models\CrossSums;

use App\CrossSums\PuzzleSnapshot;
use App\CrossSums\RiddleSnapshot;
use PHPUnit\Framework\TestCase;

class PuzzleSnapshotTest extends TestCase
{
    public function testSnapshotWillSaveRiddleSnapshotsProperly(): void
    {
        $riddleSnapshot1 = $this->createMock(RiddleSnapshot::class);
        $riddleSnapshot2 = $this->createMock(RiddleSnapshot::class);
        $riddleSnapshot3 = $this->createMock(RiddleSnapshot::class);
        $riddleSnapshot4 = $this->createMock(RiddleSnapshot::class);
        $riddleSnapshot5 = $this->createMock(RiddleSnapshot::class);
        $riddleSnapshot6 = $this->createMock(RiddleSnapshot::class);
        $snapshot = new PuzzleSnapshot($riddleSnapshot1, $riddleSnapshot2, $riddleSnapshot3, $riddleSnapshot4, $riddleSnapshot5, $riddleSnapshot6);
        $this->assertSame($riddleSnapshot1, $snapshot->getTopSnapshot());
        $this->assertSame($riddleSnapshot2, $snapshot->getMiddleSnapshot());
        $this->assertSame($riddleSnapshot3, $snapshot->getBottomSnapshot());
        $this->assertSame($riddleSnapshot4, $snapshot->getLeftSnapshot());
        $this->assertSame($riddleSnapshot5, $snapshot->getCenterSnapshot());
        $this->assertSame($riddleSnapshot6, $snapshot->getRightSnapshot());
    }
}
