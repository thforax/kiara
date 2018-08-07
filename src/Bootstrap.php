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
namespace App;

// Load Router class to access to current controller and action names
use Framework\Router;

/**
 * Bootstrap class
 *
 * Manage database and check authentification
 */
class Bootstrap
{
    public function initialize()
    {
        // Start sessions
        session_start();
        // If user isn't connected
        if (!isset($_SESSION['user']['id'])) {
            // Allowed controller list if user isn't connected
            $allowControllerList = array('Login', 'Error');
            // Check if user have right to acces to a page
            if (!in_array(Router::getController(), $allowControllerList)) {
                // Fallback to unauthorized page of login
                header('Location: /login/index/error/unauthorized');
                exit();
            }
        }
    }
}
