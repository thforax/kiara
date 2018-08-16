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

/**
 * Controller Login
 */
class Login
{
    /**
     * Action index
     *
     * @since   1.0
     */
    public function index()
    {
        // Load view
        require(APP_VIEW . DS . 'Login' . DS . 'index.php');
    }

    /**
     * Action login
     *
     * @since   1.0
     */
    public function login()
    {
        $returnArray = array();
        if (!isset($_POST['login']) || empty($_POST['login'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'LOGIN';
            $returnArray['error']['message'] = 'Veuillez renseigner votre identifiant.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'PASSWORD';
            $returnArray['error']['message'] = 'Veuillez renseigner votre mot de passe.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $userModel = new User();
        $user = $userModel->getByLogin($_POST['login']);
        if ($user === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'USER_UNKNOW';
            $returnArray['error']['message'] = 'Votre identifiant / mot de passe est incorrecte.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        if (!password_verify($_POST['password'], $user['usr_password'])) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'USER_UNKNOW';
            $returnArray['error']['message'] = 'Votre identifiant / mot de passe est incorrecte.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $result = $userModel->updateConnection($user['usr_id']);
        if ($result === false) {
            $returnArray['success'] = false;
            $returnArray['error']['code'] = 'USER_CONNEXION';
            $returnArray['error']['message'] = 'Une erreur est survenue durant votre connexion.';
            header('Content-Type: application/json');
            echo json_encode($returnArray);
            exit();
        }
        $_SESSION['user']['id'] = $user['usr_id'];
        $_SESSION['user']['login'] = $_POST['login'];
        $returnArray['success'] = true;
        header('Content-Type: application/json');
        echo json_encode($returnArray);
        exit();
    }

    public function logout()
    {
        unset($_SESSION);
        session_destroy();
        header('Location: /login/index/error/disconnected');
        exit();
    }
}
