<?php declare(strict_types=1);

spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    $path = __DIR__."/../classes/";
    $extension = ".class.php";
    $fullpath = $path . $className . $extension;

    if(!file_exists($fullpath)) {
    	return false;
    }

    include_once $fullpath;
}