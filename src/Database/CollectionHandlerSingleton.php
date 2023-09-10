<?php

declare(strict_types=1);

namespace Sportradar\Database;

use ErrorException;
use Exception;

final class CollectionHandlerSingleton
{
    private static ?CollectionHandlerInterface $collectionHandler;

    private function __construct()
    {
        try {
            self::$collectionHandler = new CollectionHandler();
        } catch (ErrorException $exception) {
            self::$collectionHandler = null;
            echo $exception->getMessage();
        }
    }

    public static function getInstance(): CollectionHandlerInterface
    {
        if (!isset(self::$collectionHandler)) {
            new self();
        }
        return self::$collectionHandler;
    }

    /**
     * We don't want to clone our object. It is prohibited in this concept.
     */
    protected function __clone()
    {
    }

    /**
     * Object shouldn't be restorable from strings. It would clone the object - it is prohibited in this concept.
     *
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
