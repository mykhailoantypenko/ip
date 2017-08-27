<?php

$root = dirname(__DIR__);

if (file_exists($root . '/vendor/autoload.php')) {
    require_once($root . '/vendor/autoload.php');
} else {
    spl_autoload_register(function ($name) use ($root) {
        $path = explode('\\', $name);

        $classPath = $root . '/src/'  . array_pop($path) . '.php';
        if (file_exists($classPath)) {
            include $classPath;
        }
    });
}
