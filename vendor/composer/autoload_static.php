<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd71990cc39631c58ca0e6d1e14200a15
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Shakahl\\SocketIO\\' => 17,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Predis\\' => 7,
        ),
        'M' => 
        array (
            'MessagePack\\' => 12,
        ),
        'E' => 
        array (
            'ElephantIO\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Shakahl\\SocketIO\\' => 
        array (
            0 => __DIR__ . '/..' . '/shakahl/socket.io-php-emitter/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'MessagePack\\' => 
        array (
            0 => __DIR__ . '/..' . '/rybakit/msgpack/src',
        ),
        'ElephantIO\\' => 
        array (
            0 => __DIR__ . '/..' . '/wisembly/elephant.io/src',
            1 => __DIR__ . '/..' . '/wisembly/elephant.io/test',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/workerman/phpsocket.io-emitter/src',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd71990cc39631c58ca0e6d1e14200a15::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd71990cc39631c58ca0e6d1e14200a15::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInitd71990cc39631c58ca0e6d1e14200a15::$fallbackDirsPsr4;

        }, null, ClassLoader::class);
    }
}
