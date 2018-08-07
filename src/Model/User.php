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

use Framework\Database;

/**
 * Model User
 */
class User
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPdo();
    }

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

    public function updateConnection($id)
    {
        $select = "UPDATE t_user
        SET usr_date_connection = NOW()
        WHERE usr_id = :id";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function getActive()
    {
        $select = "SELECT usr_id, usr_login
        FROM t_user
        WHERE usr_date_connection >= DATE_SUB(NOW(), INTERVAL 20 MINUTE)";
        $statement = $this->pdo->prepare($select);
        if ($statement->execute()) {
            $userList = $statement->fetchAll();
            if (!empty($userList)) {
                return $userList;
            }
        }
        return false;
    }
}
