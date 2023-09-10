<?php

declare(strict_types=1);

namespace Sportradar\Database;

use ErrorException;

final class CollectionHandler implements CollectionHandlerInterface
{
    private const COLLECTION_FILE = __DIR__ . '/../../data/collection.json';

    private string $currentCollectionFile;

    /**
     * @throws ErrorException
     */
    public function __construct()
    {
        $this->currentCollectionFile =
            (getenv('TEST_COLLECTION'))
                ? getenv('TEST_COLLECTION')
                : self::COLLECTION_FILE;

        if (file_exists($this->currentCollectionFile)) {
            echo 'Collection file already exists. Correct.' . PHP_EOL;
            return;
        }

        if (!fopen($this->currentCollectionFile, "w")) {
            throw new ErrorException('File could not be created.');
        }
    }

    public function getCollection(): ?array
    {
        return $this->getDecodedFileContent();
    }

    public function updateEntry(int $entryIndex, array $updatedEntry): bool
    {
        $collection = $this->getDecodedFileContent();
        $collection[$entryIndex] = $updatedEntry;

        return $this->saveCollection($collection);
    }

    public function insertEntry(array $entry): bool
    {
        $collection   = $this->getDecodedFileContent();
        $collection[] = $entry;

        return $this->saveCollection($collection);
    }

    private function saveCollection(array $collection): bool
    {
        if (
            file_put_contents(
                $this->currentCollectionFile,
                json_encode(
                    $collection
                )
            )
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function getDecodedFileContent(): ?array
    {
        return json_decode(file_get_contents($this->currentCollectionFile), true);
    }
}
