<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit278c7d99ce710c36c1976c894474a860
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit278c7d99ce710c36c1976c894474a860::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit278c7d99ce710c36c1976c894474a860::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}