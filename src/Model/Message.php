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
 * Model Message
 */
class Message
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPdo();
    }

    public function getLast()
    {
        $select = "SELECT MSG.msg_content, MSG.msg_date,
        MSG.usr_id, USR.usr_login
        FROM t_message MSG
        LEFT JOIN t_user USR ON MSG.usr_id = USR.usr_id
        ORDER BY MSG.msg_date DESC
        LIMIT 0, 20";
        $statement = $this->pdo->prepare($select);
        if ($statement->execute()) {
            $message = $statement->fetchAll();
            if (!empty($message)) {
                return $message;
            }
        }
        return false;
    }

    public function post($user_id, $message)
    {
        $select = "INSERT INTO t_message(usr_id, msg_content, msg_date)
        VALUES(:user_id, :message, NOW())";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $statement->bindParam(':message', $message, \PDO::PARAM_STR);
        return $statement->execute();
    }
}
