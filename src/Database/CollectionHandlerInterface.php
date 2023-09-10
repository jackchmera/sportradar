<?php

namespace Sportradar\Database;

interface CollectionHandlerInterface
{
    public function getCollection(): ?array;

    public function updateEntry(int $entryIndex, array $updatedEntry): bool;

    public function insertEntry(array $entry): bool;
}
