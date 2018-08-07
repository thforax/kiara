<?php
/**
 * Minimum framework for Kiara
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */
namespace Framework;

// Load Router class of lite framework
use Framework\Router;

/**
 * Core class
 *
 * Entry point
 */
class Core
{
    /**
     * Constructor
     *
     * @since   1.0
     */
    public function __construct()
    {
    }

    /**
     * Load bootstrap
     *
     * Will load \App\Bootstrap class.
     *
     * @since   1.0
     * @return  bool True is file is loaded else false.
     */
    private function bootstrap()
    {
        if (!class_exists('\App\Bootstrap')) {
            throw new \Exception('Bootstrap "\App\Bootstrap" doesn\' exist.');
            return false;
        }
        $bootstrap = new \App\Bootstrap();
        if (!method_exists($bootstrap, 'initialize')) {
            $errorMessage = 'initialize() method isn\'t available in Bootstrap "\App\Bootstrap".<br />';
            throw new \Exception($errorMessage);
            return false;
        }
        $bootstrap->initialize();
        return true;
    }

    /**
     * Load controller
     *
     * Load controller and action defined during routage and then destroy it.
     *
     * @since   1.0
     * @return  string|bool Return body content or false if controller can't be loaded.
     */
    private function controller()
    {
        $controllerName = Router::getController();
        $actionName = Router::getAction();
        $controllerNamespace = '\App\Controller\\' . $controllerName;
        if (!class_exists($controllerNamespace)) {
            throw new \Exception('Controller "' . $controllerNamespace . '" doesn\' exist.');
            return false;
        }
        $controller = new $controllerNamespace();
        if (!method_exists($controllerNamespace, 'render')) {
            $errorMessage = 'render() method isn\'t available in Controller "' . $controllerNamespace . '".<br />';
            $errorMessage .= 'Your controller may not extends \Framework\Controller.';
            throw new \Exception($errorMessage);
            return false;
        }
        $bodyContent = $controller->render($actionName);
        return $bodyContent;
    }

    /**
     * Run MVC
     *
     * Start by resolve routage
     * After start bootstrap and launch mvc by calling controller
     *
     * @since   1.0
     * @return  void
     */
    public function run()
    {
        // Launch routage
        Router::resolve();
        // Load Bootstrap
        $this->bootstrap();
        // Launch Controller defined by routage
        $bodyContent = $this->controller();
        // Show body content return by Controller
        echo $bodyContent;
    }
}
