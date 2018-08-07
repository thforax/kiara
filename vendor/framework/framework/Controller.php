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

/**
 * Controller class
 *
 * Launch controller and call View if defined
 */
class Controller
{
    /**
     * @var     string Path of application root
     * @since   1.0
     */
    private $applicationPath;

    /**
     * @var     bool See if view is enable (by default true)
     * @since   1.0
     */
    private $viewEnable = true;

    /**
     * Constructor
     *
     * Initialize Controller
     *
     * @since   1.0
     * @return  void
     */
    final public function __construct()
    {
        $libraryPath = DS . 'vendor' . DS . 'framework' . DS . 'framework';
        $this->applicationPath = str_replace($libraryPath, '', __DIR__);
    }

    /**
     * Call initialize method if exist
     * Launch controller
     * Get View render if enable
     *
     * @since   1.1
     * @param   string $action Name of Action
     * @return  string bodyContent of Controller, Layout and View
     */
    final public function render($action)
    {
        // Get current controller namespace
        $controllerNamespace = get_class($this);
        // Get current controller name
        $controller = basename(str_replace('\\', '/', $controllerNamespace));
        // Call initialize method in Controller if exists
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
        // Launch action of controller
        ob_start();
        $actionResult = $this->$action();
        echo PHP_EOL;
        $bodyContent = ob_get_clean();
        // If Controller's Action return false, disable Layout and View
        if ($actionResult !== false && $this->viewEnable === true) {
            $viewDirectory = $this->applicationPath . DS . 'src' . DS . 'View';
            $viewPath = $viewDirectory . DS . ucfirst($controller) . DS . $action . '.php';
            if (!file_exists($viewPath)) {
                trigger_error('View file "' . $viewPath . '" doesn\'t exist.', E_USER_ERROR);
                return false;
            }
            ob_start();
            require($viewPath);
            echo PHP_EOL;
            $bodyContent .= ob_get_clean();
        }
        return $bodyContent;
    }
}
