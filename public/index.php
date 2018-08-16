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
if (!defined('APP_VIEW')) {
    define('APP_VIEW', APP_ROOT . DS . 'src' . DS . 'View');
}

// Launch Composer autoload
require dirname(__DIR__) . '/vendor/autoload.php';

// Start session
session_start();

// Get current controller and action
$controller = 'Index';
$action = 'index';
$url = $_SERVER['REQUEST_URI'];
if (substr($url, -1) == '/') {
    $url = substr($url, 0, -1);
}
$urlValueList = explode('/', $url);
array_shift($urlValueList);
foreach ($urlValueList as $indexValue => $urlValue) {
    if ($indexValue == 0) {
        $controller = ucfirst($urlValue);
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

// Test if user have right to acces to page
if (!isset($_SESSION['user']) && $controller != 'Login' && $controller != 'Error') {
    header('Location: /login/index/error/unauthorized');
    exit();
}

// Test if controller and action exist
$fallback = false;
$controllerNamespace = '\App\Controller\\' . $controller;
if (class_exists($controllerNamespace) === false) {
    $fallback = true;
}
if (method_exists($controllerNamespace, $action) === false) {
    $fallback = true;
}
if ($fallback === true) {
    header('Location: /error/index/code/404');
    exit();
}

// Load controller and action
$objController = new $controllerNamespace();
$objController->$action();
