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
 * Model Message
 */
class Message
{
    public $pdo;

    /**
     * Init PDO object
     *
     * @since   1.0
     */
    public function __construct()
    {
        $this->pdo = $this->pdo = new \PDO('mysql:host=localhost;dbname=kiara', 'kiara', 'k6RLi5oKgfO6nwGY', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }

    /**
     * Get last message
     *
     * @since   1.0
     */
    public function getLast()
    {
        $select = "SELECT MSG.msg_id, MSG.msg_content, MSG.msg_date,
        MSG.usr_id, USR.usr_login
        FROM t_message MSG
        LEFT JOIN t_user USR ON MSG.usr_id = USR.usr_id
        ORDER BY MSG.msg_date DESC
        LIMIT 0, 5";
        $statement = $this->pdo->prepare($select);
        if ($statement->execute()) {
            $message = $statement->fetchAll();
            if (!empty($message)) {
                return $message;
            }
        }
        return false;
    }

    /**
     * Get message after defined id
     *
     * @since   1.0
     */
    public function getAfter($messageId)
    {
        $select = "SELECT MSG.msg_id, MSG.msg_content, MSG.msg_date,
        MSG.usr_id, USR.usr_login
        FROM t_message MSG
        LEFT JOIN t_user USR ON MSG.usr_id = USR.usr_id
        WHERE MSG.msg_id > :message_id
        ORDER BY MSG.msg_date ASC";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':message_id', $messageId, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }

    /**
     * Get message before defined id
     *
     * @since   1.0
     */
    public function getBefore($messageId)
    {
        $select = "SELECT MSG.msg_id, MSG.msg_content, MSG.msg_date,
        MSG.usr_id, USR.usr_login
        FROM t_message MSG
        LEFT JOIN t_user USR ON MSG.usr_id = USR.usr_id
        WHERE MSG.msg_id < :message_id
        ORDER BY MSG.msg_date DESC
        LIMIT 0, 5";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':message_id', $messageId, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return $statement->fetchAll();
        }
        return false;
    }

    /**
     * Post a new message
     *
     * @since   1.0
     */
    public function post($userId, $message)
    {
        $select = "INSERT INTO t_message(usr_id, msg_content, msg_date)
        VALUES(:user_id, :message, NOW())";
        $statement = $this->pdo->prepare($select);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->bindParam(':message', $message, \PDO::PARAM_STR);
        return $statement->execute();
    }
}
