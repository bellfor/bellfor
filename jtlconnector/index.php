<?php

require_once(getcwd() . "/../admin/config.php");

defined('CONNECTOR_DIR') || define('CONNECTOR_DIR', __DIR__);
defined('LOG_DIR') || define('LOG_DIR', DIR_LOGS . 'jtlconnector/');

$application = null;
try {
    if (!file_exists(LOG_DIR)) {
        mkdir(LOG_DIR);
    }
    if (file_exists(CONNECTOR_DIR . '/connector.phar')) {
        //if (is_writable(sys_get_temp_dir())) {
            include_once 'phar://' . CONNECTOR_DIR . '/connector.phar/src/bootstrap.php';
       // } else {
       //     echo sprintf('Directory %s is not writable.', sys_get_temp_dir());
       // }
    } else {
        include_once CONNECTOR_DIR . '/src/bootstrap.php';
    }
} catch (\Exception $e) {
    if (is_object($application)) {
        $handler = $application->getErrorHandler()->getExceptionHandler();
        $handler($e);
    }
}