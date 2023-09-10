<?php

namespace Sportradar\Entities\Game;

interface GameInterface
{
    public function startGame(string $homeTeam, string $awayTeam): void;
    public function finishGame(int $gameId): void;
    public function updateScore(int $gameId, int $homeScore, int $awayScore): void;
    public function getScoreboard(): array;
}
