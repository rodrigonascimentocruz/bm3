<?php
spl_autoload_register('cf7_vc_autoloader');
function cf7_vc_autoloader($class_name)
{
    if (false !== strpos($class_name, 'NjtCf7Vc')) {
        $classes_dir = CF7_VC_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.class.php';
        require_once $classes_dir . $class_file;
    }
}
