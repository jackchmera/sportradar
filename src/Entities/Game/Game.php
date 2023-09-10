<?php

declare(strict_types=1);

namespace Sportradar\Entities\Game;

use Sportradar\Database\CollectionHandlerInterface;
use Sportradar\Entities\Game\Enums\GameStatusEnums;

final class Game implements GameInterface
{
    public function __construct(private readonly CollectionHandlerInterface $collectionHandler)
    {
    }

    public function startGame(string $homeTeam, string $awayTeam): void
    {
        $games = $this->getGames();

        if (
            $this->collectionHandler->insertEntry(
                [
                    'id' => (is_null($games)) ? 1 : count($games) + 1,
                    'homeTeam' => $homeTeam,
                    'awayTeam' => $awayTeam,
                    'scoreHome' => 0,
                    'scoreAway' => 0,
                    'started_at' => time(),
                    'status' => GameStatusEnums::ONGOING->value,
                ]
            )
        ) {
            echo "Game has been created" . PHP_EOL;
        } else {
            echo "Game has not been NOT created" . PHP_EOL;
        }
    }

    public function finishGame(int $gameId): void
    {
        $games                       = $this->getGames();
        $gameIndex                   = $this->getGameIndexByGameId($gameId, $games);
        $games[$gameIndex]['status'] = GameStatusEnums::FINISHED->value;

        if (
            $this->collectionHandler->updateEntry(
                $gameIndex,
                $games[$gameIndex]
            )
        ) {
            echo "Game has been finished" . PHP_EOL;
        } else {
            echo "Game has not been finished" . PHP_EOL;
        }
    }

    public function updateScore(int $gameId, int $homeScore, int $awayScore): void
    {
        $games                          = $this->getGames();
        $gameIndex                      = $this->getGameIndexByGameId($gameId, $games);
        $games[$gameIndex]['scoreHome'] = $homeScore;
        $games[$gameIndex]['scoreAway'] = $awayScore;

        if (
            $this->collectionHandler->updateEntry(
                $gameIndex,
                $games[$gameIndex]
            )
        ) {
            echo "Score has been updated." . PHP_EOL;
        } else {
            echo "Score has been updated" . PHP_EOL;
        }
    }

    public function getScoreboard(): array
    {
        $filteredGames = array_filter(
            $this->getGames(),
            function ($game) {
                return $game['status'] === GameStatusEnums::ONGOING->value;
            }
        );

        usort(
            $filteredGames,
            function ($a, $b) {
                $sortByScore = ($a['scoreHome'] + $a['scoreAway']) <=> ($b['scoreHome'] + $b['scoreAway']);

                if ($sortByScore === 0) {
                    return $a['started_at'] <=> $b['started_at'];
                }

                return $sortByScore;
            }
        );

        return array_reverse($filteredGames);
    }

    private function getGameIndexByGameId(int $gameId, $games): int
    {
        return array_search($gameId, array_column($games, 'id'));
    }

    private function getGames(): ?array
    {
        return $this->collectionHandler->getCollection();
    }
}
