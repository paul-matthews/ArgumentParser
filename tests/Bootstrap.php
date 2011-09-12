<?php
if (!defined('PS')) {
    define('PS', PATH_SEPARATOR);
}
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('APPLICATION_ROOT')) {
    define('APPLICATION_ROOT', dirname(__DIR__) . '/app');
}

set_include_path(implode(PS, array_merge(explode(PS, get_include_path()), array(
    APPLICATION_ROOT,
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
