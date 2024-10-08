<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita2dff02f6453c4094ad389c13fcb5441
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Badore\\ContabiForm\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Badore\\ContabiForm\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita2dff02f6453c4094ad389c13fcb5441::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita2dff02f6453c4094ad389c13fcb5441::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita2dff02f6453c4094ad389c13fcb5441::$classMap;

        }, null, ClassLoader::class);
    }
}
