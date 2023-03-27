<?php

/**
 * Реализация Singleton
 * Есть единственный в своём роде объект, который не наследуется и не создаётся снова
 */
final class Connection
{
    /**
     * Summary of instance
     * @var Connection|null
     */
    private static ?self $instance = null;
    /**
     * Summary of name
     * @var string
     */
    private static string $name;

    /**
     * Summary of getInstance
     * @return Connection
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return self::$name;
    }

    /**
     * @param string $name 
     */
    public static function setName(string $name): void
    {
        self::$name = $name;
        return;
    }

    public function __clone(): void
    {
        // Deny
    }

    public function __wakeup(): void
    {
        // Deny
    }
}

$connection = Connection::getInstance();
$connection::setName('Singleton');
$connection2 = Connection::getInstance();
var_dump($connection::getName(), $connection2::getName());