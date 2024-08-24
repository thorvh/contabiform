<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita2dff02f6453c4094ad389c13fcb5441
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInita2dff02f6453c4094ad389c13fcb5441', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita2dff02f6453c4094ad389c13fcb5441', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita2dff02f6453c4094ad389c13fcb5441::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
