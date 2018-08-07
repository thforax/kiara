<?php
/**
 * Minimum framework for Kiara
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */
namespace Framework;

/**
 * Database class
 *
 * Defined a connection to a database by PDO
 */
class Database
{
    /**
     * @var     \PDO Object PDO created when connection is effectued
     * @since   1.0
     */
    private static $pdo;

    /**
     * Do a connection
     *
     * Do a connection to a database by parameters
     *
     * @since   1.0
     * @param   string $dsn Dsn.
     * @param   string $user User.
     * @param   string $password Password.
     * @param   array $optionList Option array.
     * @return  bool True if success or false.
     */
    public function connect($dsn, $user, $password, $optionList)
    {
        try {
            self::$pdo = new \PDO(
                $dsn,
                $user,
                $password,
                $optionList
            );
            return true;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
    }

    /**
     * Get current connection
     *
     * @since   1.0
     * @return  \PDO Get PDO object
     */
    public function getPdo()
    {
        return self::$pdo;
    }
}
