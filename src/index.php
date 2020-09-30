<?php declare(strict_types=1);

include 'include/autoloader.inc.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$csvfile="";
if(@$argv) {
	foreach(@$argv as $value)
	{
	    $csvfile = $value;  
	}
}


$object = new Import();
$object->upload(__DIR__."/".(($csvfile) ? $csvfile : @$_REQUEST['file']));