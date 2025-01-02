<?php
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
define("SITE_PATH", $_SERVER['DOCUMENT_ROOT']);


## includes
require __DIR__ . '/core/includes/config.inc.php';

## SESSIONS
require __DIR__ . '/core/includes/session.inc.php';
session_start();

## Classes
require __DIR__ . '/core/classes/dbase.class.php';
require __DIR__ . '/core/classes/firstrun.class.php';
require __DIR__ . '/core/classes/misc.class.php';


## initialize classes
$db = new db;
$misc = new misc;
// $dashboard = new dashboard;
$firstRun = new firstRun;

## Connect to sql
$dbconn = $db->connect($sql);

## finally including defines
// define("BASE_URL", $misc->url_origin($_SERVER)); 
// require __DIR__ . '/core/includes/defines.inc.php';




// Install check
$tables = mysqli_query($dbconn, "SHOW TABLES LIKE 'settings'");
if(mysqli_num_rows($tables) == 0) {
    echo "FAILED! DATABASE IS NOT SET UP!";
	exit;
}


## session stuff
if(!empty($_SESSION)) {
	// $smarty->assign('acpUser', $_SESSION['username']);
}

// $smarty->assign('baseUrl', BASE_URL);
// $smarty->assign('siteTitle', SITE_TITLE);
// $smarty->assign('footer', FOOTER_TEXT);
// $smarty->assign('imgUrl', IMG_URL);



?>