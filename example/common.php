<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
define('ACCESS_TOKEN', 'xxxxxxx');

// 所有错误和异常记录
ini_set('error_reporting', E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', false);
ini_set('ignore_repeated_errors', true);
ini_set('log_errors', true);
ini_set('error_log', './error.log');

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    error_log(date('[Y-m-d H:i:s]') . " Runtime Error: $errstr in $errfile:$errline" . PHP_EOL, 3, ini_get('error_log'));
}, error_reporting());

set_exception_handler(function ($e) {
    error_log(date('[Y-m-d H:i:s]') . " Exception Error: {$e->getMessage()}" . PHP_EOL, 3, ini_get('error_log'));
});

register_shutdown_function(function () {
    if (is_null($error = error_get_last())) {
        return;
    }
    if (in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        error_log(date('[Y-m-d H:i:s]') . " Fatal Error: {$error['message']}" . PHP_EOL, 3, ini_get('error_log'));
    }
});

require_once ROOT_PATH . 'vendor/autoload.php';

// 格式化输出
function dump()
{
    $args = func_get_args();

    foreach ($args as $arg) {
        if (is_array($arg)) {
            echo '<pre>' . print_r($arg, 1) . '</pre>';
        } else {
            var_dump($arg);
        }
        echo '<br>';
    }
}