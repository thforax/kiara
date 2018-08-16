<?php
/**
 * Kiara
 * Sample chat with mvc
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */
namespace App\Model;

/**
 * Model User
 */
class User
{
    public $pdo;

    /**
     * Init PDO object
     *
     * @since   1.0
     */
    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=kiara', 'kiara', 'k6RLi5oKgfO6nwGY', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }

    /**
     * Get user information from his login
     *
     * @since   1.0
     */
    public function getByLogin($login)
    {
        $select = "SELECT usr_id, usr_password
        FROM t_user
        WHERE usr_login = :login";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':login', $login, \PDO::PARAM_STR);
        if ($statement->execute()) {
            $user = $statement->fetch();
            if (!empty($user)) {
                return $user;
            }
        }
        return false;
    }

    /**
     * Update connection date
     *
     * @since   1.0
     */
    public function updateConnection($id)
    {
        $select = "UPDATE t_user
        SET usr_date_connection = NOW()
        WHERE usr_id = :id";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * Get list of active user
     *
     * @since   1.0
     */
    public function getActive()
    {
        $select = "SELECT usr_id, usr_login
        FROM t_user
        WHERE usr_date_connection >= DATE_SUB(NOW(), INTERVAL 20 MINUTE)
        AND usr_id != :id";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':id', $_SESSION['user']['id'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }
}
