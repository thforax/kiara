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
 * Router class
 *
 * Define controller and action from url
 */
class Router
{
    /**
     * @var     string Controller defined by Router
     * @since   1.0
     */
    private static $controller;

    /**
     * @var     string Action defined by Router
     * @since   1.0
     */
    private static $action;

    /**
     * @var     array Parameters list get from URL
     * @since   1.0
     */
    private static $parameterList;

    /**
     * Auto resolve a Route from URL by separator
     *
     * @since   1.0
     * @param   string $urlValueList Liste of url part.
     * @return  void
     */
    private static function autoResolve($urlValueList)
    {
        $controller = 'Index';
        $action = 'index';
        $paramList = array();
        foreach ($urlValueList as $indexValue => $urlValue) {
            if ($indexValue == 0) {
                $controller = $urlValue;
            } elseif ($indexValue == 1) {
                $action = $urlValue;
            } else {
                if (isset($urlValueList[$indexValue]) && $indexValue % 2 == 0) {
                    $paramName = $urlValueList[$indexValue];
                    $paramValue = null;
                    if (isset($urlValueList[$indexValue + 1])) {
                        $paramValue = $urlValueList[$indexValue + 1];
                    }
                    $paramList[$paramName] = $paramValue;
                }
            }
        }
        // Set controller
        self::setController($controller);
        // Set action to route action
        self::setAction($action);
        // Set param list
        self::setParameter($paramList);
    }

    /**
     * Check if controller and action exist, else change to fallback controller and action
     *
     * @since   1.0
     * @return  void
     */
    private static function checkController()
    {
        $useFallback = false;
        $controllerNamespace = '\App\Controller\\' . self::getController();
        if (class_exists($controllerNamespace) === false) {
            $useFallback = true;
        }
        if (method_exists($controllerNamespace, self::getAction()) === false) {
            $useFallback = true;
        }
        if ($useFallback === true) {
            // Set controller
            self::setController('Error');
            // Set action to route action
            self::setAction('index');
            // Set action to route action
            $fallbackParameter = array('code' => 404);
            self::setParameter($fallbackParameter);
        }
    }

    /**
     * Get action defined by Router.
     *
     * @since   1.0
     * @return  string Action defined by Router.
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * Get controller defined by Router.
     *
     * @since   1.0
     * @return  string Controller defined by Router.
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * Get parameter defined by Router.
     *
     * @since   1.0
     * @return  array Parameter defined by Router.
     */
    public static function getParameter()
    {
        return self::$parameterList;
    }

    /**
     * List of value defined in URL.
     *
     * @since   1.0
     * @param   string $url Current URL.
     * @return  array List of value defined in URL.
     */
    private static function listValue($url)
    {
        $regexSeparator = preg_quote('/');
        $listValue = preg_split("{[" . $regexSeparator . "]}", $url);
        array_shift($listValue);
        return $listValue;
    }

    /**
     * Remove last separtor in URL.
     *
     * @since   1.0
     * @param   string $url Current URL.
     * @return  string Url without last separator.
     */
    private static function removeLastSeparator($url)
    {
        $lastChar = substr($url, -1);
        if ($lastChar == '/') {
            $url = substr($url, 0, -1);
        }
        return $url;
    }

    /**
     * Call differnant action in Router to resolve road from URL.
     *
     * @since   1.0
     * @return  void
     */
    public static function resolve()
    {
        $url = $_SERVER['REQUEST_URI'];
        // Remove last char of URL if it's a separator
        $url = self::removeLastSeparator($url);
        // Get list of value of this URL
        $urlValueList = self::listValue($url);
        // Resolve route
        self::autoResolve($urlValueList);
        // Check if controller exist else change controller and action to error
        self::checkController();
        // Put GET param in GLOBAL var $_GET
        self::setParameterInGlobal();
    }

    /**
     * Set action defined by Router from URL.
     *
     * @since   1.0
     * @param   string $action Action.
     * @return  void
     */
    private static function setAction($action)
    {
        self::$action = $action;
    }

    /**
     * Set controller defined by Router from URL.
     *
     * @since   1.0
     * @param   string $controller Controller.
     * @return  void
     */
    private static function setController($controller)
    {
        self::$controller = ucfirst($controller);
    }

    /**
     * Set parameter get from URL.
     *
     * @since   1.0
     * @param   string $parameterList Parameter List.
     * @return  void
     */
    private static function setParameter($parameterList)
    {
        self::$parameterList = $parameterList;
    }

    /**
     * Transfert GET parameter to $_GET global array.
     *
     * @since   1.0
     * @return  void
     */
    private static function setParameterInGlobal()
    {
        $_GET = self::$parameterList + $_GET;
    }
}
