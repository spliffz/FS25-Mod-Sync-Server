<?php
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
define("SITE_PATH", $_SERVER['DOCUMENT_ROOT']);


// HTTPS Check workaround
if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false))
$_SERVER['HTTPS']='on';


## includes
// include(SITE_PATH.'/core/includes/smarty.inc.php');
require SITE_PATH .'/core/includes/smarty.inc.php';
// include(SITE_PATH.'/core/includes/config.inc.php');
require SITE_PATH . '/core/includes/config.inc.php';

## SESSIONS
// include(SITE_PATH.'/core/includes/session.inc.php');
require SITE_PATH . '/core/includes/session.inc.php';
session_start();

## Classes
require SITE_PATH . '/core/classes/dbase.class.php';
require SITE_PATH . '/core/classes/misc.class.php';
require SITE_PATH . '/core/classes/dashboard.class.php';
require SITE_PATH . '/core/classes/firstrun.class.php';


## initialize classes
$db = new db;
$misc = new misc;
$dashboard = new dashboard;
$firstRun = new firstRun;

## Connect to sql
$dbconn = $db->connect($sql);

## finally including defines
define("BASE_URL", $misc->url_origin($_SERVER)); 
require SITE_PATH . '/core/includes/defines.inc.php';




// Install check
$tables = mysqli_query($dbconn, "SHOW TABLES LIKE 'settings'");
if(mysqli_num_rows($tables) == 0) {
	//install.php
	header('location: '.BASE_URL.'/INSTALL/install.php');
	exit;
}



## session stuff
if(!empty($_SESSION)) {
	$smarty->assign('acpUser', $_SESSION['username']);
}

$smarty->assign('baseUrl', BASE_URL);
$smarty->assign('siteTitle', SITE_TITLE);
$smarty->assign('footer', FOOTER_TEXT);
$smarty->assign('imgUrl', IMG_URL);



?>