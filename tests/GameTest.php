<?php

declare(strict_types=1);

namespace Sportradar\Tests;

use PHPUnit\Framework\TestCase;
use Sportradar\Entities\Game\Game;
use Sportradar\Entities\Game\GameFactory;

class GameTest extends TestCase
{
    private Game $game;
    private static string $testCollection;
    public static function setUpBeforeClass(): void
    {
        // Path has to be relative to the CollectionHelper.php file.
        static::$testCollection = realpath($_SERVER["DOCUMENT_ROOT"]) . '/data/test_collection.json';
        putenv('TEST_COLLECTION=' . static::$testCollection);
    }

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->game = (new GameFactory())->createGame();
    }

    public function tearDown(): void
    {
        file_put_contents(static::$testCollection, '');
    }

    public function testStartGame(): void
    {
        $this->game->startGame('Poland', 'Austria');
        $this->assertEquals(
            '[{"id":1,"homeTeam":"Poland","awayTeam":"Austria","scoreHome":0,"scoreAway":0,"started_at":' . time() . ',"status":"ongoing"}]',
            file_get_contents(static::$testCollection)
        );
    }

    public function testFinishGame(): void
    {
        $this->game->startGame('Poland', 'Austria');
        $this->game->finishGame(1);

        $this->assertEquals(
            '[{"id":1,"homeTeam":"Poland","awayTeam":"Austria","scoreHome":0,"scoreAway":0,"started_at":' . time() . ',"status":"finished"}]',
            file_get_contents(static::$testCollection)
        );
    }

    public function testUpdateScore(): void
    {
        $this->game->startGame('Poland', 'Austria');
        $this->game->updateScore(1, 1, 2);

        $this->assertEquals(
            '[{"id":1,"homeTeam":"Poland","awayTeam":"Austria","scoreHome":1,"scoreAway":2,"started_at":' . time() . ',"status":"ongoing"}]',
            file_get_contents(static::$testCollection)
        );
    }

    public function testGetScoreboard(): void
    {
        $timeMeCa = time();
        $this->game->startGame('Mexico', 'Canada');
        $this->game->updateScore(1, 0, 5);

        $timeSpBr = time();
        $this->game->startGame('Spain', 'Brazil');
        $this->game->updateScore(2, 10, 2);

        $timeGeFr = time();
        $this->game->startGame('Germany', 'France');
        $this->game->updateScore(3, 2, 2);

        $timeUrIt = time();
        $this->game->startGame('Uruguay', 'Italy');
        $this->game->updateScore(4, 6, 6);

        $timeArAu = time();
        $this->game->startGame('Argentina', 'Australia');
        $this->game->updateScore(5, 3, 1);

        $this->assertEquals(
            json_decode(
                '[{"id":4,"homeTeam":"Uruguay","awayTeam":"Italy","scoreHome":6,"scoreAway":6,"started_at":' . $timeUrIt . ',"status":"ongoing"},{"id":2,"homeTeam":"Spain","awayTeam":"Brazil","scoreHome":10,"scoreAway":2,"started_at":' . $timeSpBr . ',"status":"ongoing"},{"id":1,"homeTeam":"Mexico","awayTeam":"Canada","scoreHome":0,"scoreAway":5,"started_at":' . $timeMeCa . ',"status":"ongoing"},{"id":5,"homeTeam":"Argentina","awayTeam":"Australia","scoreHome":3,"scoreAway":1,"started_at":' . $timeArAu . ',"status":"ongoing"},{"id":3,"homeTeam":"Germany","awayTeam":"France","scoreHome":2,"scoreAway":2,"started_at":' . $timeGeFr . ',"status":"ongoing"}]',
                true
            ),
            $this->game->getScoreboard()
        );
    }
}
