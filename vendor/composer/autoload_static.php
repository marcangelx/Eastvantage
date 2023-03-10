<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite62ebba91ba21a2ac13d1a6ace9780ac
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Utility\\' => 8,
        ),
        'C' => 
        array (
            'Class\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Utility\\' => 
        array (
            0 => __DIR__ . '/../..' . '/utils',
        ),
        'Class\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite62ebba91ba21a2ac13d1a6ace9780ac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite62ebba91ba21a2ac13d1a6ace9780ac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite62ebba91ba21a2ac13d1a6ace9780ac::$classMap;

        }, null, ClassLoader::class);
    }
}
