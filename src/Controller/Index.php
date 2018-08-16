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
namespace App\Controller;

use \App\Model\Message;
use \App\Model\User;

/**
 * Controller Index
 */
class Index
{
    /**
     * Action index
     *
     * @since   1.0
     */
    public function index()
    {
        // Load view
        require(APP_VIEW . DS . 'Index' . DS . 'index.php');
    }

    /**
     * Action userList
     *
     * Load user list and return it in JSON object for ajax
     *
     * @since   1.0
     */
    public function userList()
    {
        // Create return array
        $returnArray = array();
        // Load User model
        $userModel = new User();
        // Get active user list
        $userActiveList = $userModel->getActive();
        // If return is an error
        if ($userActiveList === false) {
            // Send JSON error return
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'USER_LIST';
            $returnArray['error']['message'] = 'Erreur lors de la récupération des utilisateurs.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        // Create return data array
        $returnData = array();
        $index = 0;
        // Foreach user add to data array
        foreach ($userActiveList as $userActive) {
            $returnData[$index]['id'] = $userActive['usr_id'];
            $returnData[$index]['login'] = $userActive['usr_login'];
            $index++;
        }
        // Return json success with data array
        $returnArray['success'] = true;
        $returnArray['data'] = $returnData;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }

    /**
     * Action messageList
     *
     * Load message list and return it in JSON object for ajax
     *
     * @since   1.0
     */
    public function messageList()
    {
        // Create a return array for Json
        $returnArray = array();
        // Get last or first message id
        $messageId = $_GET['id'];
        // Get type a get (before or after)
        $getType = $_GET['type'];
        // Init Message model
        $messageModel = new Message();
        // If message id is 0 (so first get of message)
        if ($messageId == 0) {
            // Get last message
            $messageList = $messageModel->getLast();
        } else if ($getType == 'before') {
            // Get before message id message
            $messageList = $messageModel->getBefore($messageId);
        } else if ($getType == 'after') {
            // Get all message after id
            $messageList = $messageModel->getAfter($messageId);
        }
        // If message list return false return json error
        if ($messageList === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'MESSAGE_LIST';
            $returnArray['error']['message'] = 'Erreur lors de la récupération des messages.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        // Create data array for json
        $returnData = array();
        $index = 0;
        // Foreach message move to data array
        foreach ($messageList as $message) {
            $returnData[$index]['id'] = $message['msg_id'];
            // Class is for css style of div
            $returnData[$index]['class'] = 'incoming';
            if ($message['usr_id'] == $_SESSION['user']['id']) {
                $returnData[$index]['class'] = 'outgoing';
            }
            $returnData[$index]['message'] = nl2br($message['msg_content']);
            $returnData[$index]['author'] = $message['usr_login'];
            $returnData[$index]['date'] = $message['msg_date'];
            $index++;
        }
        // Return formeted data in Json
        $returnArray['success'] = true;
        $returnArray['data'] = $returnData;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }

    /**
     * Action post
     *
     * Post a new message
     *
     * @since   1.0
     */
    public function post()
    {
        // Create return array for json
        $returnArray = array();
        // If message isn't send by post or is empty return error
        if (!isset($_POST['message']) || empty($_POST['message'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'MSG_EMPTY';
            $returnArray['error']['message'] = 'Veuillez indiquer un message.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        // Secure message content
        $message = htmlentities($_POST['message']);
        // Load Message model
        $messageModel = new Message();
        // Call post method
        $result = $messageModel->post(
            $_SESSION['user']['id'],
            $message
        );
        // If add failed return json error message
        if ($result === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'POST_SQL';
            $returnArray['error']['message'] = 'L\'ajout du message à échoué.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        // Else return success message
        $returnArray['success'] = true;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }
}
