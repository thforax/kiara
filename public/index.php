<?php
/**
 * The Front Controller for handling every request
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */

// Define a short constant
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('APP_ROOT')) {
    $appRootPath = str_replace(DS . 'public', '', __DIR__);
    define('APP_ROOT', $appRootPath);
}

// Launch Composer autoload
require dirname(__DIR__) . '/vendor/autoload.php';

// Start session
session_start();

// Get current controller and action
$controller = 'Index';
$action = 'index';
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
            $_GET[$paramName] = $paramValue;
        }
    }
}

// Load controller and action
$controllerNamespace = '\App\Controller\\' . $controller;
$objController = new $controllerNamespace();
$objController->$action();
