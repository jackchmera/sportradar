<?php

declare(strict_types=1);

namespace Sportradar\Entities\Game;

use Sportradar\Entities\Game\Game;

interface GameFactoryInterface
{
    public static function createGame(): Game;
}
