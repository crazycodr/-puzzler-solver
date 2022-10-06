<?php

namespace Tests\Sudoku\Models;

use App\Sudoku\Models\Zone;
use PHPUnit\Framework\TestCase;

class ZoneTest extends TestCase
{
    public function testStartColumnIsPersistedAndAccessible(): void
    {
        $zone = new Zone(3, 6, 4, 7);
        $this->assertEquals(3, $zone->getStartColumn());
    }

    public function testEndColumnIsPersistedAndAccessible(): void
    {
        $zone = new Zone(3, 6, 4, 7);
        $this->assertEquals(6, $zone->getEndColumn());
    }

    public function testStartRowIsPersistedAndAccessible(): void
    {
        $zone = new Zone(3, 6, 4, 7);
        $this->assertEquals(4, $zone->getStartRow());
    }

    public function testEndRowIsPersistedAndAccessible(): void
    {
        $zone = new Zone(3, 6, 4, 7);
        $this->assertEquals(7, $zone->getEndRow());
    }

}
