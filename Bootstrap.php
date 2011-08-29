<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
set_include_path(implode(DS, array_merge(explode(DS, get_include_path()), array(
    __DIR__,
))));

spl_autoload_register(function ($class_name) {
    $file_name = sprintf(
        '%s.php',
        implode(DS, explode('_', $class_name))
    );

    foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
        $file = $path . DS . $file_name;
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
});
