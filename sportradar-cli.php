<?php

declare(strict_types=1);

use Sportradar\Entities\Game\GameFactory;

require_once __DIR__ . '/vendor/autoload.php';

$game = (new GameFactory())->createGame();

switch ($argv[1]) {
    case 'start-game':
        $game->startGame($argv[2], $argv[3]);
        break;
    case 'finish-game':
        $game->finishGame((int) $argv[2]);
        break;
    case 'update-score':
        $game->updateScore((int) $argv[2], (int) $argv[3], (int) $argv[4]);
        break;
    case 'get-scoreboard':
        var_dump($game->getScoreboard());
        break;
    case 'help':
    default:
        echo 'help';
}
