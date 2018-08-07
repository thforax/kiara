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

use \App\Model\User;
// Class for manage data from a form
use \Framework\Form;
// Class for generate a json message
use \Framework\Json;

/**
 * Controller Login
 */
class Login extends \Framework\Controller
{
    /**
     * Action index
     *
     * @since   1.0
     */
    public function index()
    {
    }

    /**
     * Action login
     *
     * @since   1.0
     */
    public function login()
    {
        $this->enableView(false);
        $json = new Json();
        // Define form test
        $formRule = array(
            'login' => array(
                'notEmpty' => array(
                    'message' => 'Votre identifiant n\'est pas renseignée.'
                )
            ), 'password' => array(
                'notEmpty' => array(
                    'message' => 'Votre mot de passe n\'est pas renseigné.'
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
        $userModel = new User();
        $user = $userModel->getByLogin($formData['login']);
        if ($user === false) {
            $json->setSuccess(false);
            $json->setError('USER_UNKNOW', 'Votre identifiant / mot de passe est incorrecte.');
            $json->send();
            return false;
        }
        if (!password_verify($formData['password'], $user['usr_password'])) {
            $json->setSuccess(false);
            $json->setError('USER_UNKNOW', 'Votre identifiant / mot de passe est incorrecte.');
            $json->send();
            return false;
        }
        $result = $userModel->updateConnection($user['usr_id']);
        if ($result === false) {
            $json->setSuccess(false);
            $json->setError('USER_CONNEXION', 'Une erreur est survenue durant votre connexion.');
            $json->send();
            return false;
        }
        $_SESSION['user']['id'] = $user['usr_id'];
        $_SESSION['user']['login'] = $formData['login'];
        $json->setSuccess(true);
        $json->send();
        return true;
    }

    public function logout()
    {
        $this->enableView(false);
        unset($_SESSION);
        session_destroy();
        header('Location: /login/index/error/disconnected');
        exit();
    }
}
