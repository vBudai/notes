<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit72003b969795e44e7b7fdf2ca5f5d516
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit72003b969795e44e7b7fdf2ca5f5d516', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit72003b969795e44e7b7fdf2ca5f5d516', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit72003b969795e44e7b7fdf2ca5f5d516::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
