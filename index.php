<?php
include_once ('config/config.php');
include_once ('lib/Autoload.php');
include_once ('lib/ScanDir.php');
ini_set('display_errors', 1);
$src = Autoload::getInstance(SRC_DIR, false)->getClasses();
$lib = Autoload::getInstance(LIB_DIR, false)->getClasses();
$classes = array_merge($src, $lib);

if (isset($_POST['post']))
{
    $include = $_POST['post'];
    unset($_POST['post']);
    include ($include);
}

new Main();

function __autoload($class)
{
    global $classes;
    include_once ($classes[$class]);
}
?>