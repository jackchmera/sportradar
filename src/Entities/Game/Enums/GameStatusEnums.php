<?php

declare(strict_types=1);

namespace Sportradar\Entities\Game\Enums;

enum GameStatusEnums: string
{
    case NOT_STARTED = 'not started';
    case ONGOING     = 'ongoing';
    case FINISHED    = 'finished';
}
