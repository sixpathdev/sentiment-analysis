<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3821ffaf469dd41398c4b9fcdf6d569c
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sentiment\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sentiment\\' => 
        array (
            0 => __DIR__ . '/..' . '/davmixcool/php-sentiment-analyzer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3821ffaf469dd41398c4b9fcdf6d569c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3821ffaf469dd41398c4b9fcdf6d569c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}