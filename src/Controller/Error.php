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

/**
 * Controller Error
 */
class Error extends \Framework\Controller
{
    /**
     * Action index
     *
     * @since   1.0
     */
    public function index()
    {
        // List of error code
        $codeList = array(
            403 => array(
                'http' => 'HTTP/1.1 403 Forbidden',
                'title' => 'Accès refusé',
                'text' => 'Vous ne pouvez pas accéder à cette page.'
            ),
            404 => array(
                'http' => 'HTTP/1.1 404 Not Found',
                'title' => 'Page non trouvée',
                'text' => 'La page que vous avez demandée n\'a pas été trouvée.'
            ),
            405 => array(
                'http' => 'HTTP/1.1 405 Method Not Allowed',
                'title' => 'Méthode refusée',
                'text' => 'Votre méthode de connexion à cette page web est refusée.'
            ),
            500 => array(
                'http' => 'HTTP/1.1 500 Internal Server Error',
                'title' => 'Erreur interne du serveur',
                'text' => 'Une erreur interne du serveur s\'est produite, veuillez réessayer ultérieurement.'
            ),
            520 => array(
                'http' => 'HTTP/1.1 520 Unknown Error',
                'title' => 'Erreur inconnue',
                'text' => 'Une erreur inconnue s\'est produite, veuillez réessayer ultérieurement.'
            )
        );
        // If not error code is return
        if (!isset($_GET['code'])) {
            // Defined error code to 520
            $_GET['code'] = 520;
        }
        // Test if error code is manage by kiara
        if (array_key_exists($_GET['code'], $codeList)) {
            // If yes define errorcode
            $errorCode = $_GET['code'];
        } else {
            // Else defined to 520 error
            $errorCode = 520;
        }
        // Test if it's an ajax request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Get http error message
            $httpMessage = $codeList[$errorCode]['http'];
            // Send this error message in headers
            header($httpMessage);
            return false;
        } else { // Else it's a normal HTTP request
            // Send code of error to view
            $this->setVar('code', $errorCode);
            // Send title of error to view
            $this->setVar('title', $codeList[$errorCode]['title']);
            // Send text of error to view
            $this->setVar('text', $codeList[$errorCode]['text']);
            return true;
        }
    }
}
