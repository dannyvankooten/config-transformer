<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbc81674f8e0c1a1b3d135de778d4ad8c
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

        spl_autoload_register(array('ComposerAutoloaderInitbc81674f8e0c1a1b3d135de778d4ad8c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbc81674f8e0c1a1b3d135de778d4ad8c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbc81674f8e0c1a1b3d135de778d4ad8c::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        $filesToLoad = \Composer\Autoload\ComposerStaticInitbc81674f8e0c1a1b3d135de778d4ad8c::$files;
        $requireFile = static function ($fileIdentifier, $file) {
            if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
                $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

                require $file;
            }
        };
        foreach ($filesToLoad as $fileIdentifier => $file) {
            ($requireFile)($fileIdentifier, $file);
        }

        return $loader;
    }
}
