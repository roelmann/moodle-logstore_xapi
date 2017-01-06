<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit00ac581b5d77b64ad7537f351093faf7
{
    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'logstore_xapi\\' => 14,
        ),
        'X' => 
        array (
            'XREmitter\\Tests\\' => 16,
            'XREmitter\\' => 10,
        ),
        'T' => 
        array (
            'TinCan\\' => 7,
            'Tests\\' => 6,
        ),
        'M' => 
        array (
            'MXTranslator\\Tests\\' => 19,
            'MXTranslator\\' => 13,
        ),
        'L' => 
        array (
            'LogExpander\\Tests\\' => 18,
            'LogExpander\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'logstore_xapi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'XREmitter\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/xapi-recipe-emitter/tests',
        ),
        'XREmitter\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/xapi-recipe-emitter/src',
        ),
        'TinCan\\' => 
        array (
            0 => __DIR__ . '/..' . '/rusticisoftware/tincan/src',
        ),
        'Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'MXTranslator\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/moodle-xapi-translator/tests',
        ),
        'MXTranslator\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/moodle-xapi-translator/src',
        ),
        'LogExpander\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/moodle-log-expander/tests',
        ),
        'LogExpander\\' => 
        array (
            0 => __DIR__ . '/..' . '/learninglocker/moodle-log-expander/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit00ac581b5d77b64ad7537f351093faf7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit00ac581b5d77b64ad7537f351093faf7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}