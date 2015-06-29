<?php 
header("Content-Type: text/html; charset=utf-8");
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

$site_url = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "config/";
if (is_dir($site_url)) {
        if ($dh = opendir($site_url)) {
            while (($config = readdir($dh)) !== false) {

                $filename = $site_url . '/' . $config;
                if ($config !== '.' && $config !== '..') {
                    require_once($filename);
                }
            }
            closedir($dh);
        }
    }



if(ERRORS){
ini_set("display_errors",1);
error_reporting(E_ALL);
}  else {
ini_set("display_errors",0);
error_reporting(0);
}

$_SESSION['start_time'] = 0;
$load_time_start = time();

session_start();
$dir = array(SYSTEM_PATH, CONTROLLER, MODEL, VIEW,MODULES);
foreach ($dir as $folder) {
    $dh = opendir($folder);
// Открыть известный каталог и начать считывать его содержимое
    if (is_dir($folder)) {
        if ($dh = opendir($folder)) {
            while (($file = readdir($dh)) !== false) {

                $filename = $folder . '/' . $file;
                if ($file !== '.' && $file !== '..') {
                    include($filename);
                }
            }
            closedir($dh);
        }
    }
}

//ajax
include('ajax/ajax.php');

$c = new Controller_Index();
$r = new Router();
$r->action_index();
$r->getUrlParameters();

$_SESSION['start_time'] = $load_time_start;