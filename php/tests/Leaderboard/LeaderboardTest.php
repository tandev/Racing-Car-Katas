<?php

declare(strict_types=1);

namespace Tests\Leaderboard;

use PHPUnit\Framework\TestCase;
use RacingCar\Leaderboard\Driver;
use RacingCar\Leaderboard\Leaderboard;
use RacingCar\Leaderboard\Race;
use RacingCar\Leaderboard\SelfDrivingCar;

class LeaderboardTest extends TestCase
{
    private Driver $driver1;

    private Driver $driver2;

    private Driver $driver3;

    private SelfDrivingCar $selfDrivingCar;

    private Race $race1;

    private Race $race2;

    private Race $race3;

    private Leaderboard $leaderboard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->driver1 = new Driver('Nico Rosberg', 'DE');
        $this->driver2 = new Driver('Lewis Hamilton', 'UK');
        $this->driver3 = new Driver('Sebastian Vettel', 'DE');
        $this->selfDrivingCar = new SelfDrivingCar('1.2', 'Acme');

        $this->race1 = new Race('Australian Grand Prix', [$this->driver1, $this->driver2, $this->driver3]);
        $this->race2 = new Race('Malaysian Grand Prix', [$this->driver3, $this->driver2, $this->driver1]);
        $this->race3 = new Race('Chinese Grand Prix', [$this->driver2, $this->driver1, $this->driver3]);
        $this->selfDrivingCar->algorithmVersion = '1.4';

        $this->leaderboard = new Leaderboard([$this->race1, $this->race2, $this->race3]);
    }

    public function testShouldSumThePoints(): void
    {
        // setup

        // act
        $results = $this->leaderboard->getDriverResults();

        // verify
        $this->assertArrayHasKey('Lewis Hamilton', $results);
        $this->assertSame(18 + 18 + 25, $results['Lewis Hamilton']);
    }

    public function testShouldFindWinner(): void
    {
        // setup

        // act
        $result = $this->leaderboard->getDriverRankings();

        // verify
        $this->assertSame('Lewis Hamilton', $result[0]);
    }

    public function testShouldKeepAllDriversWhenSamePoints(): void
    {
        // setup
        // bug, drops drivers with same points
        $winner1 = new Race('Australian Grand Prix', [$this->driver1, $this->driver2, $this->driver3]);
        $winner2 = new Race('Malaysian Grand Prix', [$this->driver2, $this->driver1, $this->driver3]);
        $exEquoLeaderboard = new Leaderboard([$winner1, $winner2]);

        // act
        $rankings = $exEquoLeaderboard->getDriverRankings();

        // verify
        $this->assertSame([$this->driver1->name, $this->driver2->name, $this->driver3->name], $rankings);
        // note: the order of driver1 and driver2 is platform dependent
    }
}
