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
        // Initialise un objet de test du formulaire par rapport aux valeur passer en POST
        $formValidation = new Form($formRule, $_POST);
        // Prepare les données de post pour leur inclusion en bdd
        $formData = $formValidation->prepare();
        // Test le formulaire
        $formError = $formValidation->validate();
        // Test si le formulaire comporte une erreur
        if ($formError !== true) {
            // Envoi une requete JSON d'erreur car une erreur a été retourner lors du test du formulaire
            $json->setSuccess(false);
            $errorCode = strtoupper($formError['name'] . '_' . $formError['error']);
            $json->setError($errorCode, $formError['message']);
            $json->send();
            return false;
        }
        $json->setSuccess(true);
        $json->send();
        return true;
        /*$userModel = new User();
        $userModel->getByUsername();*/
    }
}
