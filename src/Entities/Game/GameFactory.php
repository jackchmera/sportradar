<?php

declare(strict_types=1);

namespace Sportradar\Entities\Game;

use Sportradar\Database\CollectionHandlerSingleton;

final class GameFactory implements GameFactoryInterface
{
    public static function createGame(): Game
    {
        return new Game(CollectionHandlerSingleton::getInstance());
    }
}
