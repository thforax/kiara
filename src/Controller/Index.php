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
        /*$userModel = new User();
        $userActiveList = $userModel->getActive();
        $messageModel = new Message();
        $messageList = $messageModel->getLast();*/
        // Load view
        require(APP_VIEW . DS . 'Index' . DS . 'index.php');
    }

    public function userList()
    {
        $returnArray = array();
        $userModel = new User();
        $userActiveList = $userModel->getActive();
        if ($userActiveList === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'USER_LIST';
            $returnArray['error']['message'] = 'Erreur lors de la récupération des utilisateurs.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $returnData = array();
        $index = 0;
        foreach ($userActiveList as $userActive) {
            $returnData[$index]['id'] = $userActive['usr_id'];
            $returnData[$index]['login'] = $userActive['usr_login'];
            $index++;
        }
        $returnArray['success'] = true;
        $returnArray['data'] = $returnData;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }

    public function messageList()
    {
        $returnArray = array();
        $messageId = 0;
        if (isset($_GET['id'])) {
            $messageId = $_GET['id'];
        }
        $getType = $_GET['type'];
        $messageModel = new Message();
        if ($getType == 'before') {
            $messageList = $messageModel->getBefore($messageId);
        } else if ($getType == 'after') {
            $messageList = $messageModel->getAfter($messageId);
        }
        if ($messageList === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'MESSAGE_LIST';
            $returnArray['error']['message'] = 'Erreur lors de la récupération des messages.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $returnData = array();
        $index = 0;
        foreach ($messageList as $message) {
            $returnData[$index]['id'] = $message['msg_id'];
            $returnData[$index]['message'] = nlbr($message['msg_content']);
            $returnData[$index]['author'] = $message['usr_login'];
            $returnData[$index]['date'] = $message['msg_date'];
            $index++;
        }
        $returnArray['success'] = true;
        $returnArray['data'] = $returnData;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }

    /**
     * Action index
     *
     * @since   1.0
     */
    public function post()
    {
        $returnArray = array();
        if (!isset($_POST['message'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'POST_FORM';
            $returnArray['error']['message'] = 'Erreur lors de la transmission du message.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        if (empty($_POST['message'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'MSG_EMPTY';
            $returnArray['error']['message'] = 'Veuillez indiquer un message.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $message = htmlentities($_POST['message']);
        $messageModel = new Message();
        $result = $messageModel->post(
            $_SESSION['user']['id'],
            $message
        );
        if ($result === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'POST_SQL';
            $returnArray['error']['message'] = 'L\'ajout du message à échoué.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $returnArray['success'] = true;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }
}
