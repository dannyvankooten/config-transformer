<?php

declare(strict_types = 1);

// inspired by https://github.com/phpstan/phpstan/blob/master/bootstrap.php
spl_autoload_register(function (string $class): void {
    static $composerAutoloader;

    // already loaded in bin/config-transformer.php
    if (defined('__CONFIG_TRANSFORMER_RUNNING__')) {
        return;
    }

    // load prefixed or native class, e.g. for running tests
    if (strpos($class, 'ConfigTransformerPrefix') === 0 || strpos($class, 'Symplify\\ConfigTransformer\\') === 0) {
        if ($composerAutoloader === null) {
            // prefixed version autoload
            $composerAutoloader = require __DIR__ . '/vendor/autoload.php';
        }

        // some weird collision with PHPStan custom rule tests
        if (! is_int($composerAutoloader)) {
            $composerAutoloader->loadClass($class);
        }
    }
});
