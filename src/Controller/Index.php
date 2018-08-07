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
// Class for manage data from a form
use \Framework\Form;
// Class for generate a json message
use \Framework\Json;

/**
 * Controller Index
 */
class Index extends \Framework\Controller
{
    /**
     * Action index
     *
     * @since   1.0
     */
    public function index()
    {
        $userModel = new User();
        $userActiveList = $userModel->getActive();
        $this->setVar('userActiveList', $userActiveList);
        $messageModel = new Message();
        $messageList = $messageModel->getLast();
        $this->setVar('messageList', $messageList);
    }

    /**
     * Action index
     *
     * @since   1.0
     */
    public function post()
    {
        $this->enableView(false);
        $json = new Json();
        // Define form test
        $formRule = array(
            'message' => array(
                'notEmpty' => array(
                    'message' => 'Veuillez indiquer un message.'
                )
            )
        );
        $formValidation = new Form($formRule, $_POST);
        $formData = $formValidation->prepare();
        $formError = $formValidation->validate();
        if ($formError !== true) {
            $json->setSuccess(false);
            $errorCode = strtoupper($formError['name'] . '_' . $formError['error']);
            $json->setError($errorCode, $formError['message']);
            $json->send();
            return false;
        }
        $messageModel = new Message();
        $result = $messageModel->post(
            $_SESSION['user']['id'],
            $formData['message']
        );
        if ($result === false) {
            $json->setSuccess(false);
            $json->setError('MESSAGE', 'L\'envoi du message à échouée.');
            $json->send();
            return false;
        }
        $json->setSuccess(true);
        $json->send();
        return true;
    }
}
