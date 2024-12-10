<?php

declare(strict_types=1);

namespace Tests\Leaderboard;

use PHPUnit\Framework\TestCase;
use RacingCar\Leaderboard\Driver;
use RacingCar\Leaderboard\Race;

class RaceTest extends TestCase
{
    private Driver $driver1;

    private Driver $driver2;

    private Driver $driver3;

    private Race $race;

    protected function setUp(): void
    {
        parent::setUp();

        $this->driver1 = new Driver('Nico Rosberg', 'DE');
        $this->driver2 = new Driver('Lewis Hamilton', 'UK');
        $this->driver3 = new Driver('Sebastian Vettel', 'DE');

        $this->race = new Race('Australian Grand Prix', [$this->driver1, $this->driver2, $this->driver3]);
    }

    public function testShouldCalculateDriverPoints(): void
    {
        $this->assertSame(25, $this->race->getPoints($this->driver1));
        $this->assertSame(18, $this->race->getPoints($this->driver2));
        $this->assertSame(15, $this->race->getPoints($this->driver3));
    }
}
