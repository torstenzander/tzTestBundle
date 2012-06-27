<?php
/*
 * This file is part of the TzTestBundle package.
 *
 * ©2012 Torsten Zander <info@tzander.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$vendorDir = __DIR__ . '/../vendor';


spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'Tz\\TestBundle\\')) {
        $path = __DIR__ . '/../' . implode('/', array_slice(explode('\\', $class), 2)) . '.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }

    if ($class === 'Kernel') {
        $file = $_SERVER['KERNEL_DIR'] . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});