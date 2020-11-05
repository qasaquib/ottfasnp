<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit33f5687044fd6569e508ee282a7f33cd
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit33f5687044fd6569e508ee282a7f33cd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit33f5687044fd6569e508ee282a7f33cd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}