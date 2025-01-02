<?php
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
define("SITE_PATH", $_SERVER['DOCUMENT_ROOT']);

// HTTPS Check workaround
if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false))
$_SERVER['HTTPS']='on';


## includes
include(SITE_PATH.'/core/includes/config.inc.php');
include(SITE_PATH.'/core/includes/smarty.inc.php');

## SESSIONS
include(SITE_PATH.'/core/includes/session.inc.php');
session_start();

## Classes
include(SITE_PATH.'/core/classes/dbase.class.php');
include(SITE_PATH.'/core/classes/misc.class.php');
include(SITE_PATH.'/core/classes/dashboard.class.php');
include(SITE_PATH.'/core/classes/firstrun.class.php');

## initialize classes
$db = new db;
$misc = new misc;
$dashboard = new dashboard;
$firstRun = new firstRun;

## Connect to sql
$dbconn = $db->connect($sql);

## finally including defines
define("BASE_URL", $misc->url_origin($_SERVER)); 
include(SITE_PATH.'/core/includes/defines.inc.php');


$smarty->assign('baseUrl', BASE_URL);
$smarty->assign('siteTitle', SITE_TITLE);
$smarty->assign('footer', FOOTER_TEXT);
$smarty->assign('imgUrl', IMG_URL);


// Main Code
if(isset($_POST['r'])) {
    switch($_POST['r']) {

        case "part1":
            echo json_encode(array('status' => 'ok', 'msg' => 'Initial Config Done.'));

            break;
        
        case "part2":
            $ret = $firstRun->firstRunCheck();
            
            if($ret['status'] == 'ok') {
                $msgs = $ret['msgs'];
                echo json_encode(array('status' => 'ok', 'msg' => $msgs));
            } else {
                echo json_encode(array('status' => 'fail', 'msg' => 'Already Installed.'));
            }
            break;
    }

} else {
    $smarty->assign('sql_host', $sql['host']);
    $smarty->assign('sql_port', $sql['dbport']);
    $smarty->assign('sql_user', $sql['user']);
    $smarty->assign('sql_pass', $sql['pass']);
    $smarty->assign('sql_db', $sql['dbase']);
    $smarty->assign('headerText', 'FS25 Sync Storage Server Installation');
    $smarty->display('install.tpl');
}

?>