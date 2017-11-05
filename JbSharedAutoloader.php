<?php

/**
 * Class JbSharedAutoloader
 * Shared autoloader
 * Usage:
 * JbSharedAutoloader::register(
 *     'Custom\\Namespace\\',
 *     __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
 * );
 */
class JbSharedAutoloader
{
    /**
     * @var array
     */
    protected static $registered = [];

    /**
     * @param $baseNameSpace
     * @param $path
     */
    public static function register($baseNameSpace, $path)
    {
        self::$registered[$baseNameSpace] = $path;
    }

    /**
     * @return array
     */
    public static function getRegistered()
    {
        return self::$registered;
    }

    public static function splRegister()
    {
        spl_autoload_register(function ($class) {

            $foundPath = null;
            $baseNameLength = 0;
            foreach (self::$registered as $baseName => $path) {
                $baseNameLength = strlen($baseName);
                if (strncmp($baseName, $class, $baseNameLength) === 0) {
                    $foundPath = $path;
                }
            }

            if (!$foundPath) {
                return;
            }

            // get the relative class name
            $relativeClass = substr($class, $baseNameLength);

            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = $foundPath . str_replace('\\', '/', $relativeClass) . '.php';

            // if the file exists, require it
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}

// Register after plugins have had a chance to use it
add_action('plugins_loaded', [JbSharedAutoloader::class, 'splRegister']);